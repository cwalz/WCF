<label><input type="checkbox" id="search_{$option->optionName}" name="searchOptions[{$option->optionName}]"{if $searchOption} checked{/if}> {lang}wcf.user.option.searchRadioButtonOption{/lang}</label>
<select id="{$option->optionName}" name="values[{$option->optionName}]"{if !$searchOption} disabled{/if}{if $option->required} required{/if}>
	{if !$allowEmptyValue|empty}<option value="">{lang}wcf.global.noSelection{/lang}</option>{/if}
	{foreach from=$selectOptions key=key item=selectOption}
		<option value="{$key}"{if $value == $key} selected{/if}>{lang}{@$selectOption}{/lang}</option>
	{/foreach}
</select>

<script data-relocate="true">
$(function() {
	$('#search_{$option->optionName}').change(function(event) {
		if ($(event.currentTarget).prop('checked')) {
			$('#{$option->optionName}').enable();
		}
		else {
			$('#{$option->optionName}').disable();
		}
	});
});
</script>
