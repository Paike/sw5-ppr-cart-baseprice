{extends file='parent:frontend/checkout/ajax_cart_item.tpl'}

{block name="frontend_checkout_ajax_cart_articlename_price"}
<span class="item--price">{if $basketItem.amount}{$basketItem.amount|currency}{else}{s name="AjaxCartInfoFree" namespace="frontend/checkout/ajax_cart"}{/s}{/if}*</span>
{if $pprShowAjaxCart}
	{if $basketItem.additional_details.purchaseunit != $basketItem.additional_details.referenceunit}
		<span class="ajaxcart--base-price">
			{if $basketItem.amount && $basketItem.additional_details.referenceunit}
				{assign var='pprItemPrice' value=$basketItem.amount|replace:",":"."}
				{assign var='pprPricePerUnit' value=($pprItemPrice / $basketItem.quantity)}
				{assign var='pprReferencePrice' value=($pprPricePerUnit / $basketItem.additional_details.purchaseunit * $basketItem.additional_details.referenceunit)}
				({$pprReferencePrice|round:2|currency} / {if $basketItem.additional_details.referenceunit != 1}{$basketItem.additional_details.referenceunit}{/if} {$basketItem.additional_details.sUnit.unit})
			{/if}
		</span>
	{/if}
{/if}
{/block}
						