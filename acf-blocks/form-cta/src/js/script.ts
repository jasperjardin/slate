const blockHubspotForms = document.querySelectorAll<HTMLElement>('[data-hubspot-form]');
blockHubspotForms.forEach((el) => {
	window.hbspt.forms.create({
		portalId: el.getAttribute('data-hubspot-portal-id'),
		formId: el.getAttribute('data-hubspot-form'),
		target: '#' + el.id,
		cssRequired: '',
		css: '',
		locale: document.documentElement.getAttribute('lang'),
	});
});
