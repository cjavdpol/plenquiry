document.addEventListener('DOMContentLoaded', function () {
  var i18n = (typeof plenquiry_i18n !== 'undefined') ? plenquiry_i18n : {
    success:       'Thank you! Your question has been sent.',
    error_generic: 'Something went wrong. Please try again later.',
    error_network: 'Something went wrong. Please try again later.',
  };

  document.querySelectorAll('.plenquiry-form').forEach(function (form) {
    var urlField   = form.querySelector('.plenquiry-page-url');
    var titleField = form.querySelector('.plenquiry-page-title');
    if (urlField)   urlField.value   = window.location.href;
    if (titleField) titleField.value = document.title;

    form.addEventListener('submit', function (e) {
      e.preventDefault();

      var statusEl  = form.querySelector('.plenquiry-status');
      var submitBtn = form.querySelector('.plenquiry-submit');

      statusEl.textContent = '';
      statusEl.className   = 'plenquiry-status';
      submitBtn.disabled   = true;

      fetch(form.getAttribute('action'), {
        method: 'POST',
        body: new FormData(form),
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
      })
        .then(function (response) { return response.json(); })
        .then(function (json) {
          if (json.success) {
            statusEl.textContent = i18n.success;
            statusEl.classList.add('plenquiry-success');
            form.reset();
            if (urlField)   urlField.value   = window.location.href;
            if (titleField) titleField.value = document.title;
          } else {
            statusEl.textContent = json.error || i18n.error_generic;
            statusEl.classList.add('plenquiry-error');
          }
        })
        .catch(function () {
          statusEl.textContent = i18n.error_network;
          statusEl.classList.add('plenquiry-error');
        })
        .finally(function () {
          submitBtn.disabled = false;
        });
    });
  });
});
