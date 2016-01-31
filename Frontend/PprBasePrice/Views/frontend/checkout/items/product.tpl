{extends file='parent:frontend/checkout/items/product.tpl'}

{block name='frontend_checkout_cart_tax_symbol' append}
{if !$basePriceDisplayed && $pprShowCart}
	{assign var=basePriceDisplayed value=true}
	{if $sBasketItem.additional_details.purchaseunit != $sBasketItem.additional_details.referenceunit}
		<span class="cart--base-price">
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