<?php

namespace Sedlatschek\ConditionalEqualsValidation;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Sedlatschek\ConditionalEqualsValidation\Traits\HasTypeAwareValueTranslation;

/** @phpstan-ignore-next-line */
class ConditionalRule implements Rule
{
    use HasTypeAwareValueTranslation;

    /**
     * @var \Illuminate\Support\Collection<\Sedlatschek\ConditionalEqualsValidation\Condition>
     */
    protected Collection $conditions;

    protected mixed $value;

    public function __construct(mixed $value)
    {
        $this->conditions = collect();
        $this->value = $value;
    }

    /**
     * The name of the rule.
     */
    protected function getName(): string
    {
        return Str::slug(Str::afterLast(get_class($this), '\\'), '_');
    }

    /**
     * Any one of the given `parameters` must have the given `equals` for the rule to apply.
     *
     * @param  string[]  $parameters
     */
    public function ifAnyOf(array $parameters, mixed $equals): ConditionalRule
    {
        $this->conditions->push(new ConditionAny($parameters, $equals));

        return $this;
    }

    /**
     * All of the given `parameters` must have the given `equals` for the rule to apply.
     *
     * @param  string[]  $parameters
     */
    public function ifAllOf(array $parameters, mixed $equals): ConditionalRule
    {
        $this->conditions->push(new ConditionAll($parameters, $equals));

        return $this;
    }

    /**
     * All of the given `parameters` must be different from the given `equals` for the rule to apply.
     *
     * @param  string[]  $parameters
     */
    public function ifNoneOf(array $parameters, mixed $equals): ConditionalRule
    {
        $this->conditions->push(new ConditionNone($parameters, $equals));

        return $this;
    }

    /**
     * The given `parameter` must have the given `equals` for the rule to apply.
     */
    public function if(string $parameter, mixed $equals): ConditionalRule
    {
        return $this->ifAnyOf([$parameter], $equals);
    }

    /**
     * The given `parameter` must be different from the given `equals` for the rule to apply.
     */
    public function ifNot(string $parameter, mixed $equals): ConditionalRule
    {
        return $this->ifNoneOf([$parameter], $equals);
    }

    /**
     * Get the parameters of all conditions.
     *
     * @return \Illuminate\Support\Collection<string>
     */
    protected function getAllParameters(): Collection
    {
        return $this->conditions->map(fn (Condition $condition) => $condition->getParameters())
            ->flatten();
    }

    /**
     * Check if a parameter references itself.
     *
     * @throws \Sedlatschek\ConditionalEqualsValidation\InvalidRuleDefinitionException
     */
    protected function checkForSelfReference(string $attribute): void
    {
        $parameters = $this->getAllParameters();

        if ($parameters->contains($attribute)) {
            throw new InvalidRuleDefinitionException("{$attribute} can't be used to validate {$attribute}");
        }
    }

    /**
     * Determine whether or not the conditions need to be checked using the rule value and the actual value.
     */
    protected function needsToHaveConditionsChecked(mixed $ruleValue, mixed $actualValue): bool
    {
        return $ruleValue !== $actualValue;
    }

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        $this->checkForSelfReference($attribute);

        $request = request();

        if ($this->needsToHaveConditionsChecked($this->value, $value)) {
            if (count($this->conditions) === 0) {
                $fail($this->getMessageForConditions($attribute));
            } else {
                $failing = $this->conditions->filter(
                    fn (Condition $condition) => ! $condition->validate($request)
                );

                if (count($this->conditions) === count($failing)) {
                    $fail($this->getMessageForConditions($attribute, $this->conditions));
                }
            }
        }
    }

    /**
     * @param  \Illuminate\Support\Collection<\Sedlatschek\ConditionalEqualsValidation\Condition>|null  $conditions
     */
    protected function getMessageForConditions(string $attribute, Collection|null $conditions = null): string
    {
        return __('conditional-equals-validation::messages.'.$this->getName(), [
            'attribute' => $attribute,
            'value' => $this->translateValue($this->value),
        ]).$this->getMessageConditionAppendix($conditions);
    }

    /**
     * @param  \Illuminate\Support\Collection<\Sedlatschek\ConditionalEqualsValidation\Condition>|null  $conditions
     */
    protected function getMessageConditionAppendix(Collection|null $conditions = null): string
    {
        $and = __('conditional-equals-validation::messages.and');

        return isset($conditions) && (count($conditions) > 0)
            ? ' '.$conditions->map(fn (Condition $condition) => $condition->message())->join(" $and ")
            : '';
    }

    /**
     * We only have this for Laravel 9 compatibility.
     * The class itself already works with Laravel 10 through the `validate` function.
     *
     * @deprecated
     *
     * @param  mixed  $attribute
     * @param  mixed  $value
     */
    public function passes($attribute, $value)
    {
        $result = true;
        $this->validate($attribute, $value, function () use (&$result) {
            $result = false;
        });

        return $result;
    }

    /**
     * We only have this for Laravel 9 compatibility.
     * The class itself already works with Laravel 10 through the `validate` function.
     *
     * @deprecated
     */
    public function message()
    {
        return __('conditional-equals-validation::messages.'.$this->getName(), [
            'value' => $this->translateValue($this->value),
        ]).$this->getMessageConditionAppendix($this->conditions);
    }
}
