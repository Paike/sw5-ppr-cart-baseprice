{extends file='parent:frontend/checkout/confirm_item.tpl'}

{block name='frontend_checkout_cart_item_tax_price' append}
{if $pprShowConfirm}
	{if $sBasketItem.additional_details.purchaseunit != $sBasketItem.additional_details.referenceunit}
		<span class="confirm--base-price">
			{if $sBasketItem.amount && $sBasketItem.additional_details.referenceunit}
				{assign var='pprItemPrice' value=$sBasketItem.amount|replace:",":"."}
				{assign var='pprPricePerUnit' value=($pprItemPrice / $sBasketItem.quantity)}
				{assign var='pprReferencePrice' value=($pprPricePerUnit / $sBasketItem.additional_details.purchaseunit * $sBasketItem.additional_details.referenceunit)}
				<nobr>({$pprReferencePrice|round:2|currency} / {if $sBasketItem.additional_details.referenceunit != 1}{$sBasketItem.additional_details.referenceunit}{/if} {$sBasketItem.additional_details.sUnit.unit})</nobr>
			{/if}
		</span>
	{/if}
{/if}
{/block}