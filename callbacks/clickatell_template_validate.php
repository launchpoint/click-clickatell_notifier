<?

$t = &$clickatell_template;

if (strlen($t->body_text)>160)
{
  $t->errors['body_text'] = "must be 160 characters or less.";
}