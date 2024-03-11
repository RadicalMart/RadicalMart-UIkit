/*
 * @package     RadicalMart Uikit Package
 * @subpackage  tpl_radicalmart_uikit
 * @version     2.0.0
 * @author      RadicalMart Team - radicalmart.ru
 * @copyright   Copyright (c) 2024 RadicalMart. All rights reserved.
 * @license     GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 * @link        https://radicalmart.ru/
 */

document.addEventListener('DOMContentLoaded', function () {
	let config = {
		cart: {
			addButtonsLock: true,
			displayModuleButtonsLock: true,
			discountHide: true,
			productsDiscountHide: true,
			badgeHide: true,
			badgeTooltip: true,
			moduleHide: true,
			moduleShow: true,
			pageErrors: true,
			pageReload: true,
			notification_addShow: true,
			errorsShow: true,
		},
		checkout: {
			submitButtonsLock: true,
			discountHide: true,
			checkErrorsShow: true,
			checkErrorsProductsShow: true,
			globalLoadingShow: true,
			shippingLoadingShow: true,
			paymentLoadingShow: true,
			loginShow: true,
			errorsShow: true,
			createOrderProgress: true,
		},
		login: {
			buttonsLock: true,
			fromShow: true,
			errorsShow: true,
		}
	};

	window.RadicalMartDisplay = config;
	document.dispatchEvent(new CustomEvent('onRadicalMartDisplayAfterSetConfig', {detail: config}));
});

document.addEventListener('onRadicalMartCartAfterUpdateDisplayData', function (event) {
	let hasProducts = (event.detail && event.detail.total.quantity && event.detail.total.quantity > 0);
	if (window.RadicalMartDisplay.cart.badgeHide) {
		document.querySelectorAll('.radicalmart-icon .quantity').forEach(function (badge) {
			if (hasProducts) {
				badge.style.display = '';
			} else {
				badge.style.display = 'none';
			}
		});
	}

	if (window.RadicalMartDisplay.cart.badgeTooltip) {
		document.querySelectorAll('.radicalmart-icon[uk-tooltip]').forEach(function (tooltip) {
			if (hasProducts) {
				UIkit.tooltip(tooltip, {title: event.detail.total.sum_seo});
			} else {
				UIkit.tooltip(tooltip, {title: ''});
			}
		});
	}

	if (window.RadicalMartDisplay.cart.productsDiscountHide) {
		if (hasProducts) {
			Object.keys(event.detail.products).forEach(function (key) {
				let product = event.detail.products[key];
				document.querySelectorAll('[radicalmart-cart="product-discount-block"][data-key="' + key + '"] , ' +
					'[data-radicalmart-cart="product-discount-block"][data-key="' + key + '"]')
					.forEach(function (block) {
						block.style.display = (product.order.discount_enable
							&& product.order.discount.toString().length > 0) ? '' : 'none';
					});
			});
		}
	}

	let cartPage = document.querySelector('#RadicalMart.cart');
	if (cartPage) {
		if (window.RadicalMartDisplay.cart.pageErrors) {
			let errorLines = cartPage.querySelectorAll('tr[radicalmart-cart="product"].uk-alert.uk-alert-danger');
			errorLines.forEach(function (line) {
				let quantity = line.querySelector('input[name="quantity"]');
				if (quantity) {
					let max = quantity.getAttribute('max');
					if (max) {
						max = parseFloat(max);
						if (max > 0 && parseFloat(quantity.value) <= max) {
							line.classList.remove('uk-alert', 'uk-alert-danger');

							let error = line.querySelector('.error-message');
							if (error) {
								error.remove();
							}
						}
					}
				}
			});
		}

		if (window.RadicalMartDisplay.cart.discountHide) {
			document.querySelectorAll('[radicalmart-cart="discount-block"],' +
				'[data-radicalmart-cart="discount-block"]')
				.forEach(function (block) {
					block.style.display = (event.detail.total.discount > 0) ? '' : 'none';
				});
		}
	}
});

document.addEventListener('onRadicalMartCartBeforeAddProduct', function (event) {
	if (window.RadicalMartDisplay.cart.addButtonsLock) {
		let productSelector = '[data-id="' + event.detail.product_id + '"]';
		document.querySelectorAll('[radicalmart-cart="product"]' + productSelector
			+ ',[data-radicalmart-cart="product"]' + productSelector).forEach(function (productBlock) {
			productBlock.querySelectorAll('[radicalmart-cart="add"],[data-radicalmart-cart="add"]')
				.forEach(function (button) {
					button.setAttribute('disabled', '');
					button.classList.add('uk-disabled');
				});
		});
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

	if (window.RadicalMartDisplay.cart.addButtonsLock) {
		document.querySelectorAll('[radicalmart-cart="add"],' +
			'[data-radicalmart-cart="add"]')
			.forEach(function (button) {
				button.removeAttribute('disabled');
				button.classList.remove('uk-disabled');
			});
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
			if (window.RadicalMartDisplay.cart.moduleHide) {
				let module = document.querySelector('#radicalmartCartModule');
				if (module) {
					UIkit.offcanvas(document.querySelector('#radicalmartCartModule')).hide();
				}
			}

			if (window.RadicalMartDisplay.cart.pageReload) {
				let cartPage = document.querySelector('#RadicalMart.cart');
				if (cartPage) {
					window.location.reload();
				}
			}
		}
	}
});

document.addEventListener('onRadicalMartCartRenderLayout', function (event) {
	if (event.detail.name === 'notification_add') {
		if (window.RadicalMartDisplay.cart.notification_addShow) {
			let notification = document.querySelector('#radicalmartCartNotificationAdd');
			if (notification) {
				UIkit.modal(notification).show();
			}
		}
	} else if (event.detail.name === 'module') {
		if (window.RadicalMartDisplay.cart.moduleShow) {
			let module = document.querySelector('#radicalmartCartModule');
			if (module) {
				UIkit.offcanvas(module).show();
			}
		}
	}
});

document.addEventListener('onRadicalMartCartBeforeDisplayModule', function (event) {
	if (window.RadicalMartDisplay.cart.displayModuleButtonsLock) {
		document.querySelectorAll('[radicalmart-cart="display_module"], [data-radicalmart-cart="display_module"]')
			.forEach(function (button) {
				button.setAttribute('disabled', '');
				button.classList.add('uk-disabled');
			});
	}
});

document.addEventListener('onRadicalMartCartDisplayModule', (event) => {
	if (window.RadicalMartDisplay.cart.displayModuleButtonsLock) {
		document.querySelectorAll('[radicalmart-cart="display_module"], [data-radicalmart-cart="display_module"]')
			.forEach(function (button) {
				button.removeAttribute('disabled');
				button.classList.remove('uk-disabled');
			});
	}
});

document.addEventListener('onRadicalMartCartError', function (event) {
	if (event.detail !== 'Request aborted') {
		if (window.RadicalMartDisplay.cart.errorsShow) {
			UIkit.notification(event.detail, {status: 'danger'});
		}
	}

	if (window.RadicalMartDisplay.cart.addButtonsLock) {
		document.querySelectorAll('[radicalmart-cart="add"], [data-radicalmart-cart="add"]')
			.forEach(function (button) {
				button.removeAttribute('disabled');
				button.classList.remove('uk-disabled');
			});
	}
	if (window.RadicalMartDisplay.cart.displayModuleButtonsLock) {
		document.querySelectorAll('[radicalmart-cart="display_module"], [data-radicalmart-cart="display_module"]')
			.forEach(function (button) {
				button.removeAttribute('disabled');
				button.classList.remove('uk-disabled');
			});
	}
});


document.addEventListener('onRadicalMartCheckoutBeforeUpdateDisplayData', function (event) {
	if (window.RadicalMartDisplay.checkout.submitButtonsLock) {
		document.querySelectorAll('[radicalmart-checkout="submit-button"],' +
			'[data-radicalmart-checkout="submit-button"]')
			.forEach(function (button) {
				button.setAttribute('disabled', '');
				button.classList.add('uk-disabled');
			});
	}
});

document.addEventListener('onRadicalMartCheckoutAfterUpdateDisplayData', function (event) {
	if (window.RadicalMartDisplay.checkout.submitButtonsLock) {
		document.querySelectorAll('[radicalmart-checkout="submit-button"],' +
			'[data-radicalmart-checkout="submit-button"]')
			.forEach(function (button) {
				button.removeAttribute('disabled');
				button.classList.remove('uk-disabled');
			});
	}

	if (window.RadicalMartDisplay.checkout.discountHide) {
		document.querySelectorAll('[radicalmart-checkout="discount-block"],' +
			'[data-radicalmart-checkout="discount-block"]')
			.forEach(function (block) {
				block.style.display = (event.detail && event.detail.total && event.detail.total.discount > 0) ? '' : 'none';
			});
	}
});


document.addEventListener('onRadicalMartCheckoutAfterCheckData', function (event) {
	if (event.detail) {
		if (window.RadicalMartDisplay.checkout.checkErrorsShow) {
			document.querySelectorAll('[radicalmart-checkout="check-error"],' +
				'[data-radicalmart-checkout="check-error"]')
				.forEach(function (block) {
					block.style.display = (event.detail.success) ? 'none' : '';
				});
		}

		if (event.detail.current.productsErrors && window.RadicalMartDisplay.checkout.checkErrorsProductsShow) {
			let productsErrors = [];
			Object.values(event.detail.current.productsErrors).forEach(function (error) {
				productsErrors.push(error.product_title + ': ' + error.error_message);
			});
			let productsErrorsString = productsErrors.join('<br>');

			document.querySelectorAll('[radicalmart-checkout="check-error-products"],' +
				'[data-radicalmart-checkout="check-error-products"]')
				.forEach(function (block) {
					block.innerHTML = productsErrorsString;
					block.style.display = '';
				});
		}

		if (!event.detail.success) {
			if (window.RadicalMartDisplay.checkout.submitButtonsLock) {
				document.querySelectorAll('[radicalmart-checkout="submit-button"],' +
					'[data-radicalmart-checkout="submit-button"]')
					.forEach(function (button) {
						button.setAttribute('disabled', '');
						button.classList.add('uk-disabled');
					});
			}
		}
	}
});

document.addEventListener('onRadicalMartCheckoutBeforeReloadForm', function (event) {
	if (event.detail.step === 'shipping') {
		if (window.RadicalMartDisplay.checkout.shippingLoadingShow) {
			let loading = document.querySelector('#checkout_shipping_loading');
			if (loading) {
				loading.style.display = '';
			}
		}
	} else if (event.detail.step === 'payment') {
		if (window.RadicalMartDisplay.checkout.paymentLoadingShow) {
			let loading = document.querySelector('#checkout_payment_loading');
			if (loading) {
				loading.style.display = '';
			}
		}
	}
});

document.addEventListener('onRadicalMartCheckoutBeforeCreateOrder', function (event) {
	if (window.RadicalMartDisplay.checkout.submitButtonsLock) {
		document.querySelectorAll('[radicalmart-checkout="submit-button"],' +
			'[data-radicalmart-checkout="submit-button"]')
			.forEach(function (button) {
				button.setAttribute('disabled', '');
				button.classList.add('disabled');
			});
	}

	if (window.RadicalMartDisplay.checkout.createOrderProgress) {
		let progress = document.querySelector('[radicalmart-checkout="create-order-progress"]');
		if (progress) {
			progress.innerHTML = '';
		}
	}
});


document.addEventListener('onRadicalMartCheckoutCreateOrderProgress', function (event) {
	if (window.RadicalMartDisplay.checkout.createOrderProgress) {
		if (event.detail) {
			let progress = document.querySelector('[radicalmart-checkout="create-order-progress"]');
			if (progress) {
				progress.innerHTML += '<div>' + event.detail.message + '</div>';
				if (event.detail.type === 'create-order-redirect') {
					progress.innerHTML += '<a href="' + event.detail.redirect + '">' +
						Joomla.Text._('COM_RADICALMART_CHECKOUT_CREATE_ORDER_PROGRESS_CREATE_ORDER_REQUEST_REDIRECT_LINK')
						+ '</a>';
				}
			}
		}
	}
});

document.addEventListener('onRadicalMartCheckoutRenderLayout', function (event) {
	if (event.detail.name === 'login') {
		if (window.RadicalMartDisplay.checkout.loginShow) {
			let modal = document.querySelector('#radicalmartCheckoutLogin');
			UIkit.modal(modal).show();
		}
	}
});

document.addEventListener('onRadicalMartCheckoutError', function (event) {
	if (event.detail !== 'Request aborted') {
		if (window.RadicalMartDisplay.checkout.errorsShow) {
			UIkit.notification(event.detail, {status: 'danger'});
		}
	}

	if (window.RadicalMartDisplay.checkout.submitButtonsLock) {
		document.querySelectorAll('[radicalmart-checkout="submit-button"],' +
			'[data-radicalmart-checkout="submit-button"]')
			.forEach(function (button) {
				button.removeAttribute('disabled');
				button.classList.remove('uk-disabled');
			});
	}
});

document.addEventListener('onRadicalMartLoginBeforeDisplayForm', function (event) {
	if (window.RadicalMartDisplay.login.buttonsLock) {
		document.querySelectorAll('[radicalmart-login="display_form"], [data-radicalmart-login="display_form"]')
			.forEach(function (button) {
				button.setAttribute('disabled', '');
				button.classList.add('uk-disabled');
			});
	}
});

document.addEventListener('onRadicalMartLoginAfterDisplayForm', function (event) {
	if (window.RadicalMartDisplay.login.buttonsLock) {
		document.querySelectorAll('[radicalmart-login="display_form"], [data-radicalmart-login="display_form"]')
			.forEach((button) => {
				button.removeAttribute('disabled');
				button.classList.remove('uk-disabled');
			});
	}
});

document.addEventListener('onRadicalMartLoginRenderLayout', function (event) {
	if (event.detail.name === 'form') {
		if (window.RadicalMartDisplay.login.fromShow) {
			let modal = document.querySelector('#radicalmartLoginForm');
			if (modal) {
				UIkit.modal(modal).show();
			}
		}
	}
});

document.addEventListener('onRadicalMartLoginError', (event) => {
	if (event.detail && event.detail !== 'Request aborted') {
		if (window.RadicalMartDisplay.login.errorsShow) {
			Joomla.renderMessages({
				error: [event.detail]
			});
		}
	}
	if (window.RadicalMartDisplay.login.buttonsLock) {
		document.querySelectorAll('[radicalmart-login="display_form"], [data-radicalmart-login="display_form"]')
			.forEach((button) => {
				button.removeAttribute('disabled');
				button.classList.remove('uk-disabled');
			});
	}
});