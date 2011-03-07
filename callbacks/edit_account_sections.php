<?
$user = User::find_by_id($current_user->id);

if (is_postback() && p('user'))
{
    if ($user->id == $params['user']['id'])
    {
        $user = User::find_by_id($params['user']['id']);
        $user->sms_phone_number = $params['user']['sms_phone_number'];
        $user->save();
        if ($user->is_valid)
        {
            flash("Information saved.");
        }
    }
}

$title="Text Messaging";