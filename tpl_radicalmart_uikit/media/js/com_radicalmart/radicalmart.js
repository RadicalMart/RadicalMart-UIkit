/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     __DEPLOY_VERSION__
 * @author      Delo Design - delo-design.ru
 * @copyright   Copyright (c) 2022 Delo Design. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://delo-design.ru/
 */

document.addEventListener('onRadicalMartCartError', function (event) {
	if (event.detail !== 'Request aborted') {
		UIkit.notification(event.detail, {status: 'danger'})
	}
});

document.addEventListener('onRadicalMartCheckoutError', function (event) {
	if (event.detail !== 'Request aborted') {
		UIkit.notification(event.detail, {status: 'danger'})
	}
});

document.addEventListener('onRadicalMartCartAfterAddProduct', function (event) {
	if (!event.detail.error) {
		if (window.RadicalMartTrigger) {
			window.RadicalMartTrigger({
				action: 'add_to_cart',
				product_id: event.detail.entry.product_id,
				quantity: event.detail.entry.quantity,
			})
		}
	}
});

document.addEventListener('onRadicalMartCartAfterRemoveProduct', function (event) {
	if (!event.detail.error) {
		if (window.RadicalMartTrigger) {
			window.RadicalMartTrigger({
				action: 'remove_from_cart',
				product_id: event.detail.entry.product_id,
			})
		}
		if (event.detail.cart === false) {
			let module = document.querySelector('#radicalmartCartModule');
			if (module) {
				UIkit.offcanvas(document.querySelector('#radicalmartCartModule')).hide();
			}

			let cartView = (Joomla.getOptions('radicalmart_cart') && Joomla.getOptions('radicalmart_cart').cartView);
			if (cartView) {
				window.location.reload();
			}
		}
	}
});

document.addEventListener('onRadicalMartCartAfterUpdateDisplayData', function (event) {
	let hasProducts = (event.detail && event.detail.total.quantity && event.detail.total.quantity > 0);

	document.querySelectorAll('.radicalmart-icon .quantity').forEach(function (badge) {
		if (hasProducts) {
			badge.style.display = '';
		} else {
			badge.style.display = 'none';
		}
	});

	document.querySelectorAll('.radicalmart-icon[uk-tooltip]').forEach(function (tooltip) {
		if (hasProducts) {
			UIkit.tooltip(tooltip, {title: event.detail.total.sum_seo});
		} else {
			UIkit.tooltip(tooltip, {title: ''});
		}
	});

	if (event.detail) {
		document.querySelectorAll('.cart-discount-display').forEach(function (element) {
			if (event.detail.total.discount) {
				element.style.display = '';
			} else {
				element.style.display = 'none';
			}
		});
	}
});

document.addEventListener('onRadicalMartCheckoutAfterUpdateDisplayData', function (event) {
	if (event.detail) {
		document.querySelectorAll('.checkout-discount-display').forEach(function (element) {
			if (event.detail.total.discount) {
				element.style.display = '';
			} else {
				element.style.display = 'none';
			}
		});
	}
});


document.addEventListener('onRadicalMartCartRenderLayout', function (event) {
	if (event.detail.name === 'notification_add') {
		UIkit.modal(document.querySelector('#radicalmartCartNotificationAdd')).show();
	} else if (event.detail.name === 'module') {
		UIkit.offcanvas(document.querySelector('#radicalmartCartModule')).show();
	}
});

document.addEventListener('onRadicalMartCheckoutRenderLayout', function (event) {
	if (event.detail.name === 'login') {
		UIkit.modal(document.querySelector('#radicalmartCheckoutLogin')).show();
	}
});

document.addEventListener('onRadicalMartCheckoutBeforeReloadForm', function (event) {
	if (event.detail.step === 'shipping') {
		let loading = document.querySelector('#checkout_shipping_loading');
		if (loading) {
			loading.style.display = '';
		}
	} else if (event.detail.step === 'payment') {
		let loading = document.querySelector('#checkout_payment_loading');
		if (loading) {
			loading.style.display = '';
		}
	}
});

document.addEventListener('DOMContentLoaded', function () {
	let productLightbox = document.querySelector('#RadicalMart.product .product-gallery .uk-slideshow-items');
	if (productLightbox) {
		UIkit.lightbox(productLightbox, {
			container: '#RadicalMart.product'
		});
	}
});