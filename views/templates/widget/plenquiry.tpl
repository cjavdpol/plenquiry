<div class="plenquiry-widget">
  <h3 class="plenquiry-title">
    {if $form_title}{$form_title|escape:'html':'UTF-8'}{else}{l s='Ask a question about this page' mod='plenquiry'}{/if}
  </h3>
  <form class="plenquiry-form" action="{$plenquiry_action|escape:'html':'UTF-8'}" method="post" novalidate>
    <input type="hidden" name="page_url"   class="plenquiry-page-url">
    <input type="hidden" name="page_title" class="plenquiry-page-title">

    {if $show_name_field neq 'no'}
    <div class="form-group">
      <label for="plenquiry-name">{l s='Your name' mod='plenquiry'}</label>
      <input type="text" id="plenquiry-name" name="name" class="form-control"
             placeholder="{l s='Your name' mod='plenquiry'}">
    </div>
    {/if}

    <div class="form-group">
      <label for="plenquiry-email">{l s='Your email address' mod='plenquiry'} <span class="required">*</span></label>
      <input type="email" id="plenquiry-email" name="email" class="form-control" required
             placeholder="{l s='you@example.com' mod='plenquiry'}">
    </div>

    <div class="form-group">
      <label for="plenquiry-question">{l s='Your question' mod='plenquiry'} <span class="required">*</span></label>
      <textarea id="plenquiry-question" name="question" class="form-control" rows="4" required
                placeholder="{l s='Type your question here…' mod='plenquiry'}"></textarea>
    </div>

    <button type="submit" class="btn btn-primary plenquiry-submit">
      {if $button_text}{$button_text|escape:'html':'UTF-8'}{else}{l s='Send question' mod='plenquiry'}{/if}
    </button>

    <div class="plenquiry-status" aria-live="polite"></div>
  </form>
</div>
