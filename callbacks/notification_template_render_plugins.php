<?

$title = "Clickatell Template";

$clickatell_template = get_clickatell_template_for($template);

if (is_postback() && array_key_exists('clickatell_template', $params))
{
  $clickatell_template->update_attributes($params['clickatell_template']);
  $template->extract_variables($clickatell_template, array('body_text'));
  
  if ($clickatell_template->is_valid)
  {
    flash('Clickatell template saved.');
  }
}

