<?php
/**
 * This file is part of ProFTPd Admin
 *
 * @package ProFTPd-Admin
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 *
 * @copyright Lex Brugman <lex_brugman@users.sourceforge.net>
 * @copyright Christian Beer <djangofett@gmx.net>
 * @copyright Ricardo Padilha <ricardo@droboports.com>
 *
 */

include_once ("configs/config.php");
include_once ("includes/AdminClass.php");
global $cfg;

$ac = new AdminClass($cfg);

$field_userid   = $cfg['field_userid'];
$field_id       = $cfg['field_id'];

if (empty($_REQUEST['user'])) {
    header("Location: users.php");
    die();
}

$username = $_REQUEST['user'];

$user = $ac->get_user_by_userid($username);
if (!is_array($user)) {
    $errormsg = 'User does not exist; cannot find name '.$username.' in the database.';
}

if ( isset($_REQUEST['key']) ) {
    $keyid = $_REQUEST['key'];
    if (!$ac->is_valid_id($keyid)) {
        $errormsg = 'Invalid ID; must be a positive integer.';
    } else {
        $key = $ac->get_user_key_by_id($keyid);
        if (!is_array($key)) {
            $errormsg = 'Key does not exist; cannot find KEY ID '.$id.' in the database.';
        }
    }
}

if (empty($errormsg) && !empty($_REQUEST["action"]) && $_REQUEST["action"] == "create") {
    $keydata = array(
        'user'   	=> $user[$field_userid],
        'sftp_key'	=> $_REQUEST['sftp_key']);

    if ($ac->add_user_key($keydata)) {
        $infomsg = 'key for "'.$user[$field_userid].'" created successfully.';
    } else {
        $errormsg = 'key for "'.$user[$field_userid].'" creation failed; check log files.';
    }

}

if (empty($errormsg) && !empty($_REQUEST["action"]) && $_REQUEST["action"] == "reallyremove") {

    if ($ac->remove_user_key_by_id($keyid)) {
        $infomsg = 'Key "'.$keyid.'" removed successfully.';
    } else {
        $errormsg = 'Key "'.$keyid.'" removal failed; see log files for more information.';
    }
}




/* Form values */
if (empty($errormsg)) {
    /* Default values */
    $publickey = '';
} else {
    /* This is a failed attempt */
    $publickey   = $_REQUEST['publickey'];
}

include ("includes/header.php");

include ("includes/messages.php");


if (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "add") {

    ?>
    <div class="col-xs-12 col-sm-8 col-md-6 center">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Add user SFTP public Key</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <form role="form" class="form-horizontal" method="post" data-toggle="validator">
                            <!-- User name -->
                            <div class="form-group">
                                <label for="user" class="col-sm-3 control-label">User name</label>
                                <div class="controls col-sm-9">
                                    <input readonly="readonly" type="text" class="form-control" id="user" name="user" value="<?php echo $user[$field_userid]; ?>" placeholder="Enter a user name" required />
                                </div>
                            </div>

                            <!-- Public key -->
                            <div class="form-group">
                                <label for="sftp_key" class="col-sm-3 control-label">PUBLIC KEY</label>
                                <div class="controls col-sm-9">
                                    <textarea class="form-control" id="sftp_key" name="sftp_key" rows="10" placeholder="Enter a public key"><?php echo $sftp_key; ?></textarea>
                                    <p class="help-block"><small>Public Key format : ---- BEGIN SSH2 PUBLIC KEY ----.</small></p>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <a class="btn btn-default" href="edit_user.php?action=show&<?php echo $field_id;?>=<?php echo $user[$field_id];?>">&laquo; View user <?php echo $user[$field_userid];?></a>
                                    <button type="submit" class="btn btn-primary pull-right" name="action" value="create">Create Public KEY</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } elseif (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "reallyremove") { ?>
    <!-- action: reallyremove -->
    <div class="col-xs-12 col-sm-8 col-md-6 center">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <!-- Actions -->
                        <div class="form-group">
                            <div class="col-sm-12">
                                <a class="btn btn-primary pull-right"
                                   href="edit_user.php?action=show&<?php echo $field_id;?>=<?php echo $user[$field_id];?>"
                                   role="button">Return user <?php echo $user[$field_userid];?> &raquo;</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php } elseif ( !empty($_REQUEST["action"]) && $_REQUEST["action"] == "remove" ) { ?>
    <!-- action: remove -->
    <div class="col-xs-12 col-sm-8 col-md-6 center">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Remove user SFTP Public KEY</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <form role="form" class="form-horizontal" method="post">
                            <!-- GID -->
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <p>Please confirm removal of key ID  "<?php echo $key['id']; ?>"</p>
                                    <pre><?php echo $key['sftp_key']; ?></pre>
                                </div>
                            </div>
                            <!-- Actions -->
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <a class="btn btn-default" role="group" href="edit_user.php?action=show&<?php echo $field_id; ?>=<?php echo $user[$field_id]; ?>">Cancel</a>
                                    <button type="submit" class="btn btn-danger pull-right" role="group" name="action" value="reallyremove" <?php if (isset($errormsg)) { echo 'disabled="disabled"'; } ?>>Remove Public KEY</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="col-xs-12 col-sm-8 col-md-6 center">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <!-- Actions -->
                        <div class="form-group">
                            <div class="col-sm-12">
                                <a class="btn btn-primary pull-right"
                                   href="edit_user.php?action=show&<?php echo $field_id;?>=<?php echo $user[$field_id];?>"
                                   role="button">Return user <?php echo $user[$field_userid];?> &raquo;</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }


include ("includes/footer.php");
