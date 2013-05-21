<?php
/**
 * i-MSCP - internet Multi Server Control Panel
 *
 * The contents of this file are subject to the Mozilla Public License
 * Version 1.1 (the "License"); you may not use this file except in
 * compliance with the License. You may obtain a copy of the License at
 * http://www.mozilla.org/MPL/
 *
 * Software distributed under the License is distributed on an "AS IS"
 * basis, WITHOUT WARRANTY OF ANY KIND, either express or implied. See the
 * License for the specific language governing rights and limitations
 * under the License.
 *
 * The Original Code is "VHCS - Virtual Hosting Control System".
 *
 * The Initial Developer of the Original Code is moleSoftware GmbH.
 * Portions created by Initial Developer are Copyright (C) 2001-2006
 * by moleSoftware GmbH. All Rights Reserved.
 *
 * Portions created by the ispCP Team are Copyright (C) 2006-2010 by
 * isp Control Panel. All Rights Reserved.
 *
 * Portions created by the i-MSCP Team are Copyright (C) 2010-2013 by
 * i-MSCP - internet Multi Server Control Panel. All Rights Reserved.
 *
 * @category    i-MSCP
 * @package     iMSCP_Core
 * @subpackage  Reseller
 * @copyright   2001-2006 by moleSoftware GmbH
 * @copyright   2006-2010 by ispCP | http://isp-control.net
 * @copyright   2010-2013 by i-MSCP | http://i-mscp.net
 * @author      ispCP Team
 * @author      i-MSCP Team
 * @link        http://i-mscp.net
 */

/***********************************************************************************************************************
 * Functions
 */

/**
 * Generate PHP editor block
 *
 * @param iMSCP_pTemplate $tpl
 * @param iMSCP_PHPini $phpini
 * @return void
 */
function _generatePhpBlock($tpl, $phpini)
{
	/** @var $cfg iMSCP_Config_Handler_File */
	$cfg = iMSCP_Registry::get('config');
	$htmlChecked = $cfg->HTML_CHECKED;

	$tplVars = array();

	if ($phpini->getRePermVal('phpiniSystem') == 'yes') {
		$tplVars['PHP_EDITOR_YES'] = ($phpini->getClPermVal('phpiniSystem') == 'yes') ? $htmlChecked : '';
		$tplVars['PHP_EDITOR_NO'] = ($phpini->getClPermVal('phpiniSystem') != 'yes') ? $htmlChecked : '';
		$tplVars['TR_PHP_EDITOR'] = tr('PHP Editor');
		$tplVars['TR_PHP_EDITOR_SETTINGS'] = tr('PHP Editor Settings');
		$tplVars['TR_SETTINGS'] = tr('Settings');
		$tplVars['TR_DIRECTIVES_VALUES'] = tr('Directive values');
		$tplVars['TR_FIELDS_OK'] = tr('All fields seem to be valid.');
		$tplVars['TR_VALUE_ERROR'] = tr('Value for the PHP <strong>%%s</strong> directive must be between %%d and %%d.', true);
		$tplVars['TR_CLOSE'] = tr('Close');
		$tplVars['TR_PHP_POST_MAX_SIZE_DIRECTIVE'] = tr('PHP %s directive', true, '<b>post_max_size</b>');
		$tplVars['PHP_UPLOAD_MAX_FILESIZE_DIRECTIVE'] = tr('PHP %s directive', true, '<b>upload_max_filezize</b>');
		$tplVars['TR_PHP_MAX_EXECUTION_TIME_DIRECTIVE'] = tr('PHP %s directive', true, '<b>max_execution_time</b>');
		$tplVars['TR_PHP_MAX_INPUT_TIME_DIRECTIVE'] = tr('PHP %s directive', true, '<b>max_input_time</b>');
		$tplVars['TR_PHP_MEMORY_LIMIT_DIRECTIVE'] = tr('PHP %s directive', true, '<b>memory_limit</b>');
		$tplVars['TR_MIB'] = tr('MiB');
		$tplVars['TR_SEC'] = tr('Sec.');

		$permissionsBlock = false;

		if (!$phpini->checkRePerm('phpiniAllowUrlFopen')) {
			$tplVars['PHP_EDITOR_ALLOW_URL_FOPEN_BLOCK'] = '';
		} else {
			$tplVars['TR_CAN_EDIT_ALLOW_URL_FOPEN'] = tr('Can edit the PHP %s directive', true, '<b>allow_url_fopen</b>');
			$tplVars['ALLOW_URL_FOPEN_YES'] = ($phpini->getClPermVal('phpiniAllowUrlFopen') == 'yes') ? $htmlChecked : '';
			$tplVars['ALLOW_URL_FOPEN_NO'] = ($phpini->getClPermVal('phpiniAllowUrlFopen') == 'no') ? $htmlChecked : '';
			$permissionsBlock = true;
		}

		if (!$phpini->checkRePerm('phpiniDisplayErrors')) {
			$tplVars['PHP_EDITOR_DISPLAY_ERRORS_BLOCK'] = '';
		} else {
			$tplVars['TR_CAN_EDIT_DISPLAY_ERRORS'] = tr('Can edit the PHP %s directive', true, '<b>display_errors</b>');
			$tplVars['DISPLAY_ERRORS_YES'] = ($phpini->getClPermVal('phpiniDisplayErrors') == 'yes') ? $htmlChecked : '';
			$tplVars['DISPLAY_ERRORS_NO'] = ($phpini->getClPermVal('phpiniDisplayErrors') == 'no') ? $htmlChecked : '';
			$permissionsBlock = true;
		}

		if (PHP_SAPI == 'apache2handler' || !$phpini->checkRePerm('phpiniDisableFunctions')) {
			$tplVars['PHP_EDITOR_DISABLE_FUNCTIONS_BLOCK'] = '';
		} else {
			$tplVars['TR_CAN_EDIT_DISABLE_FUNCTIONS'] = tr('Can edit the PHP %s directive', true, '<b>disable_functions</b>');
			$tplVars['DISABLE_FUNCTIONS_YES'] = ($phpini->getClPermVal('phpiniDisableFunctions') == 'yes') ? $htmlChecked : '';
			$tplVars['DISABLE_FUNCTIONS_NO'] = ($phpini->getClPermVal('phpiniDisableFunctions') == 'no') ? $htmlChecked : '';
			$tplVars['TR_ONLY_EXEC'] = tr('Only exec');
			$tplVars['DISABLE_FUNCTIONS_EXEC'] = ($phpini->getClPermVal('phpiniDisableFunctions') == 'exec') ? $htmlChecked : '';
			$permissionsBlock = true;
		}

		if (!$permissionsBlock) {
			$tplVars['PHP_EDITOR_PERMISSIONS_BLOCK'] = '';
		} else {
			$tplVars['TR_PERMISSIONS'] = tr('Permissions');
			$tplVars['TR_ONLY_EXEC'] = tr('Only exec');
		}

		$tplVars['POST_MAX_SIZE'] = $phpini->getDataVal('phpiniPostMaxSize');
		$tplVars['UPLOAD_MAX_FILESIZE'] = $phpini->getDataVal('phpiniUploadMaxFileSize');
		$tplVars['MAX_EXECUTION_TIME'] = $phpini->getDataVal('phpiniMaxExecutionTime');
		$tplVars['MAX_INPUT_TIME'] = $phpini->getDataVal('phpiniMaxInputTime');
		$tplVars['MEMORY_LIMIT'] = $phpini->getDataVal('phpiniMemoryLimit');

		$tplVars['PHP_DIRECTIVES_MAX_VALUES'] = json_encode(
			array(
				'post_max_size' => $phpini->getRePermVal('phpiniPostMaxSize'),
				'upload_max_filezize' => $phpini->getRePermVal('phpiniUploadMaxFileSize'),
				'max_execution_time' => $phpini->getRePermVal('phpiniMaxExecutionTime'),
				'max_input_time' => $phpini->getRePermVal('phpiniMaxInputTime'),
				'memory_limit' => $phpini->getRePermVal('phpiniMemoryLimit')
			)
		);
	} else {
		$tplVars['PHP_EDITOR_JS'] = '';
		$tplVars['PHP_EDITOR_BLOCK'] = '';
	}

	$tpl->assign($tplVars);
}

/**
 * Generate form
 *
 * @param $tpl iMSCP_pTemplate
 * @param int $id Hosting plan unique identifier
 * @param int $resellerId Reseller unique identifier
 * @param $phpini iMSCP_PHPini
 * @return void
 */
function generateForm($tpl, $id, $resellerId, $phpini)
{
	/** @var $cfg iMSCP_Config_Handler_File */
	$cfg = iMSCP_Registry::get('config');

	if (isset($cfg->HOSTING_PLANS_LEVEL) && $cfg->HOSTING_PLANS_LEVEL == 'admin') {
		$query = "
			SELECT
				*
			FROM
				`hosting_plans`
			WHERE
				`id` = ?
			AND
				`reseller_id` IN (SELECT `admin_id` FROM `admin` WHERE `admin_type` = 'admin')
			";
		$stmt = exec_query($query, $id);

		# Reseller is not allowed to edit any hosting plan created by administrators
		$tpl->assign(
			array(
				'READONLY' => $cfg->HTML_READONLY,
				'DISABLED' => $cfg->HTML_DISABLED,
				'SUBMIT_BUTTON' => ''
			)
		);
	} else {
		$query = "SELECT * FROM `hosting_plans` WHERE `id` = ? AND `reseller_id` = ?";
		$stmt = exec_query($query, array($id, $resellerId));
	}

	if (!$stmt->rowCount()) {
		showBadRequestErrorPage();
	}

	$data = $stmt->fetchRow();

	$description = $data['description'];
	$status = $data['status'];

	list(
		$php, $cgi, $sub, $als, $mail, $ftp, $sqld, $sqlu, $monthlyTraffic, $diskspace, $bkp, $dns, $aps, $phpEditor,
		$phpAllowUrlFopenPerm, $phpDisplayErrorsPerm, $phpDisableFunctionsPerm, $phpPostMaxSizeValue,
		$phpUploadMaxFilesizeValue, $phpMaxExecutionTimeValue, $phpMaxInputTimeValue, $phpMemoryLimitValue, $hpExtMail
	) = explode(';', $data['props']);

	$phpini->setClPerm('phpiniSystem', $phpEditor);
	$phpini->setClPerm('phpiniAllowUrlFopen', $phpAllowUrlFopenPerm);
	$phpini->setClPerm('phpiniDisplayErrors', $phpDisplayErrorsPerm);
	$phpini->setClPerm('phpiniDisableFunctions', $phpDisableFunctionsPerm);

	$phpini->setData('phpiniPostMaxSize', $phpPostMaxSizeValue, false);
	$phpini->setData('phpiniUploadMaxFileSize', $phpUploadMaxFilesizeValue, false);
	$phpini->setData('phpiniMaxExecutionTime', $phpMaxExecutionTimeValue, false);
	$phpini->setData('phpiniMaxInputTime', $phpMaxInputTimeValue, false);
	$phpini->setData('phpiniMemoryLimit', $phpMemoryLimitValue, false);

	$checked = $cfg->HTML_CHECKED;

	$tpl->assign(
		array(
			'ID' => tohtml($id),
			'NAME' => tohtml($data['name']),
			'DESCRIPTION' => tohtml($description),
			'MAX_SUB' => tohtml($sub),
			'MAX_ALS' => tohtml($als),
			'MAX_MAIL' => tohtml($mail),
			'MAX_FTP' => tohtml($ftp),
			'MAX_SQLD' => tohtml($sqld),
			'MAX_SQLU' => tohtml($sqlu),
			'MONTHLY_TRAFFIC' => tohtml($monthlyTraffic),
			'MAX_DISKSPACE' => tohtml($diskspace),
			'PHP_YES' => ($php == '_yes_') ? $checked : '',
			'PHP_NO' => ($php == '_no_') ? $checked : '',
			'CGI_YES' => ($cgi == '_yes_') ? $checked : '',
			'CGI_NO' => ($cgi == '_no_') ? $checked : '',
			'DNS_YES' => ($dns == '_yes_') ? $checked : '',
			'DNS_NO' => ($dns == '_no_') ? $checked : '',
			'BACKUPD' => ($bkp == '_dmn_') ? $checked : '',
			'BACKUPS' => ($bkp == '_sql_') ? $checked : '',
			'BACKUPF' => ($bkp == '_full_') ? $checked : '',
			'BACKUPN' => ($bkp == '_no_') ? $checked : '',
			'SOFTWARE_YES' => ($aps == '_yes_') ? $checked : '',
			'SOFTWARE_NO' => ($aps == '_no_' || !$aps) ? $checked : '',
			'EXTMAIL_YES' => ($hpExtMail == '_yes_') ? $checked : '',
			'EXTMAIL_NO' => ($hpExtMail == '_no_') ? $checked : '',
			'STATUS_YES' => ($status) ? $checked : '',
			'STATUS_NO' => (!$status) ? $checked : ''
		)
	);

	_generatePhpBlock($tpl, $phpini);
}

/**
 * Generate error form
 *
 * @param iMSCP_pTemplate $tpl
 * @param iMSCP_PHPini $phpini
 * @return void
 */
function generateErrorForm($tpl, $phpini)
{
	global $id, $name, $description, $sub, $als, $mail, $ftp, $sqld, $sqlu, $monthlyTraffic, $diskspace, $php, $cgi,
		$bkp, $dns, $aps, $hpExtMail, $status;

	/** @var $cfg iMSCP_Config_Handler_File */
	$cfg = iMSCP_Registry::get('config');
	$htmlChecked = $cfg->HTML_CHECKED;

	$tpl->assign(
		array(
			'ID' => tohtml($id),
			'NAME' => tohtml($name),
			'DESCRIPTION' => tohtml($description),
			'MAX_SUB' => tohtml($sub),
			'MAX_ALS' => tohtml($als),
			'MAX_MAIL' => tohtml($mail),
			'MAX_FTP' => tohtml($ftp),
			'MAX_SQLD' => tohtml($sqld),
			'MAX_SQLU' => tohtml($sqlu),
			'MONTHLY_TRAFFIC' => tohtml($monthlyTraffic),
			'MAX_DISKSPACE' => tohtml($diskspace),
			'PHP_YES' => ($php == '_yes_') ? $htmlChecked : '',
			'PHP_NO' => ($php == '_no_') ? $cfg->HTML_CHECKED : '',
			'CGI_YES' => ($cgi == '_yes_') ? $htmlChecked : '',
			'CGI_NO' => ($cgi == '_no_') ? $htmlChecked : '',
			'DNS_YES' => ($dns == '_yes_') ? $htmlChecked : '',
			'DNS_NO' => ($dns == '_no_') ? $htmlChecked : '',
			'BACKUPD' => ($bkp == '_dmn_') ? $htmlChecked : '',
			'BACKUPS' => ($bkp == '_sql_') ? $htmlChecked : '',
			'BACKUPF' => ($bkp == '_full_') ? $htmlChecked : '',
			'BACKUPN' => ($bkp == '_no_') ? $htmlChecked : '',
			'SOFTWARE_YES' => ($aps == '_yes_') ? $htmlChecked : '',
			'SOFTWARE_NO' => ($aps == '_no_') ? $htmlChecked : '',
			'EXTMAIL_YES' => ($hpExtMail == '_yes_') ? $htmlChecked : '',
			'EXTMAIL_NO' => ($hpExtMail == '_no_') ? $htmlChecked : '',
			'STATUS_YES' => ($status) ? $htmlChecked : '',
			'STATUS_NO' => (!$status) ? $htmlChecked : ''
		)
	);

	_generatePhpBlock($tpl, $phpini);
}

/**
 * Check input data
 *
 * @param iMSCP_PHPini $phpini
 * @return bool TRUE if data are valid, FALSE otherwise
 */
function checkInputData($phpini)
{
	global $name, $description, $sub, $als, $mail, $ftp, $sqld, $sqlu, $monthlyTraffic, $diskspace, $php, $cgi, $dns,
		$bkp, $aps, $hpExtMail, $status;

	$name = isset($_POST['hp_name']) ? clean_input($_POST['hp_name']) : '';
	$description = isset($_POST['hp_description']) ? clean_input($_POST['hp_description']) : '';

	$sub = isset($_POST['hp_sub']) ? clean_input($_POST['hp_sub']) : '-1';
	$als = isset($_POST['hp_als']) ? clean_input($_POST['hp_als']) : '-1';
	$mail = isset($_POST['hp_mail']) ? clean_input($_POST['hp_mail']) : '-1';
	$ftp = isset($_POST['hp_ftp']) ? clean_input($_POST['hp_ftp']) : '-1';
	$sqld = isset($_POST['hp_sql_db']) ? clean_input($_POST['hp_sql_db']) : '-1';
	$sqlu = isset($_POST['hp_sql_user']) ? clean_input($_POST['hp_sql_user']) : '-1';
	$monthlyTraffic = isset($_POST['hp_traff']) ? clean_input($_POST['hp_traff']) : '';
	$diskspace = isset($_POST['hp_disk']) ? clean_input($_POST['hp_disk']) : '';

	$php = isset($_POST['hp_php']) ? clean_input($_POST['hp_php']) : '_no_';
	$cgi = isset($_POST['hp_cgi']) ? clean_input($_POST['hp_cgi']) : '_no_';
	$dns = isset($_POST['hp_dns']) ? clean_input($_POST['hp_dns']) : '_no_';
	$bkp = isset($_POST['hp_backup']) ? clean_input($_POST['hp_backup']) : '_no_';
	$aps = isset($_POST['hp_softwares_installer']) ? clean_input($_POST['hp_softwares_installer']) : '_no_';
	$hpExtMail = isset($_POST['hp_external_mail']) ? clean_input($_POST['hp_external_mail']) : '_no_';

	$status = isset($_POST['hp_status']) ? clean_input($_POST['hp_status']) : '0';

	$php = ($php == '_yes_') ? '_yes_' : '_no_';
	$cgi = ($cgi == '_yes_') ? '_yes_' : '_no_';
	$dns = ($dns == '_yes_') ? '_yes_' : '_no_';
	$bkp = (in_array($bkp, array('_full_', '_dmn_', '_sql_'))) ? $bkp : '_no_';
	$aps = ($aps == '_yes_') ? '_yes_' : '_no_';
	$hpExtMail = ($hpExtMail == '_yes_') ? '_yes_' : '_no_';

	if ($name == '') set_page_message(tr('Name cannot be empty.'), 'error');
	if ($description == '') set_page_message(tr('Description cannot be empty.'), 'error');

	if (!resellerHasFeature('subdomains')) {
		$sub = '-1';
	} elseif (!imscp_limit_check($sub, -1)) {
		set_page_message(tr('Incorrect subdomains limit.'), 'error');
	}

	if (!resellerHasFeature('domain_aliases')) {
		$als = '-1';
	} elseif (!imscp_limit_check($als, -1)) {
		set_page_message(tr('Incorrect domain aliases limit.'), 'error');
	}

	if (!resellerHasFeature('mail')) {
		$mail = '-1';
	} elseif (!imscp_limit_check($mail, -1)) {
		set_page_message(tr('Incorrect mail accounts limit.'), 'error');
	}

	if (!resellerHasFeature('ftp')) {
		$ftp = '-1';
	} elseif (!imscp_limit_check($ftp, -1)) {
		set_page_message(tr('Incorrect FTP accounts limit.'), 'error');
	}

	if (!resellerHasFeature('sql_db')) {
		$sqld = '-1';
	} elseif (!imscp_limit_check($sqld, -1)) {
		set_page_message(tr('Incorrect SQL users limit.'), 'error');
	} else if ($sqlu != -1 && $sqld == -1) {
		set_page_message(tr('SQL users limit is <i>disabled</i>.'), 'error');
	}

	if (!resellerHasFeature('sql_user')) {
		$sqlu = '-1';
	} elseif (!imscp_limit_check($sqlu, -1)) {
		set_page_message(tr('Incorrect SQL databases limit.'), 'error');
	} else if ($sqlu == -1 && $sqld != -1) {
		set_page_message(tr('SQL databases limit is not <i>disabled</i>.'), 'error');
	}

	if (!imscp_limit_check($monthlyTraffic, null)) {
		set_page_message(tr('Incorrect monthly traffic limit.'), 'error');
	}

	if (!imscp_limit_check($diskspace, null)) {
		set_page_message(tr('Incorrect disk space limit.'), 'error');
	}

	if ($phpini->checkRePerm('phpiniSystem') && isset($_POST['phpiniSystem'])) {
		$phpini->setClPerm('phpiniSystem', clean_input($_POST['phpiniSystem']));

		if ($phpini->checkRePerm('phpiniAllowUrlFopen') && isset($_POST['phpini_perm_allow_url_fopen'])) {
			$phpini->setClPerm('phpiniAllowUrlFopen', clean_input($_POST['phpini_perm_allow_url_fopen']));
		}

		if ($phpini->checkRePerm('phpiniDisplayErrors') && isset($_POST['phpini_perm_display_errors'])) {
			$phpini->setClPerm('phpiniDisplayErrors', clean_input($_POST['phpini_perm_display_errors']));
		}

		if (PHP_SAPI != 'apache2handler' && $phpini->checkRePerm('phpiniDisableFunctions') &&
			isset($_POST['phpini_perm_disable_functions'])
		) {
			$phpini->setClPerm('phpiniDisableFunctions', clean_input($_POST['phpini_perm_disable_functions']));
		}

		if (
			isset($_POST['post_max_size']) &&
			!$phpini->setDataWithPermCheck('phpiniPostMaxSize', $_POST['post_max_size'])
		) {
			set_page_message(tr('Value for the PHP %s directive is out of range.', 'post_max_size'), 'error');
		}

		if (
			isset($_POST['upload_max_filesize']) &&
			!$phpini->setDataWithPermCheck('phpiniUploadMaxFileSize', $_POST['upload_max_filesize'])
		) {
			set_page_message(tr('Value for the PHP %s directive is out of range.', 'upload_max_filesize'), 'error');
		}

		if (
			isset($_POST['max_execution_time']) &&
			!$phpini->setDataWithPermCheck('phpiniMaxExecutionTime', $_POST['max_execution_time'])
		) {
			set_page_message(tr('Value for the PHP %s directive is out of range.', 'max_execution_time'), 'error');
		}

		if (
			isset($_POST['max_input_time']) &&
			!$phpini->setDataWithPermCheck('phpiniMaxInputTime', $_POST['max_input_time'])
		) {
			set_page_message(tr('Value for the PHP %s directive is out of range.', 'max_input_time'), 'error');
		}

		if (
			isset($_POST['memory_limit']) &&
			!$phpini->setDataWithPermCheck('phpiniMemoryLimit', $_POST['memory_limit'])
		) {
			set_page_message(tr('Value for the PHP %s directive is out of range.', 'memory_limit'), 'error');
		}
	}

	if ($php == '_no_' && $aps == '_yes_') {
		set_page_message(tr('The software installer require the PHP support.'), 'error');
	}

	if (!Zend_Session::namespaceIsset('pageMessages')) {
		return true;
	} else {
		return false;
	}
}

/**
 * Save new hosting plan
 *
 * @param iMSCP_PHPini $phpini
 * @return bool TRUE on success, FALSE otherwise
 */
function saveData($phpini)
{
	global $id, $name, $description, $sub, $als, $mail, $ftp, $sqld, $sqlu, $monthlyTraffic, $diskspace, $php, $cgi,
		$dns, $bkp, $aps, $hpExtMail, $status;

	$hpProps = "$php;$cgi;$sub;$als;$mail;$ftp;$sqld;$sqlu;$monthlyTraffic;$diskspace;$bkp;$dns;$aps";
	$hpProps .= ';' . $phpini->getClPermVal('phpiniSystem') . ';' . $phpini->getClPermVal('phpiniAllowUrlFopen');
	$hpProps .= ';' . $phpini->getClPermVal('phpiniDisplayErrors') . ';' . $phpini->getClPermVal('phpiniDisableFunctions');
	$hpProps .= ';' . $phpini->getDataVal('phpiniPostMaxSize') . ';' . $phpini->getDataVal('phpiniUploadMaxFileSize');
	$hpProps .= ';' . $phpini->getDataVal('phpiniMaxExecutionTime') . ';' . $phpini->getDataVal('phpiniMaxInputTime');
	$hpProps .= ';' . $phpini->getDataVal('phpiniMemoryLimit') . ';' . $hpExtMail;

	if (reseller_limits_check($_SESSION['user_id'], $hpProps)) {
		$query = "UPDATE `hosting_plans` SET `name` = ?, `description` = ?, `props` = ?, `status` = ? WHERE `id` = ?";
		exec_query($query, array($name, $description, $hpProps, $status, $id));

		return true;
	}

	set_page_message(tr('Hosting plan values exceed your own limits.'), 'error');
	return false;
}

/***********************************************************************************************************************
 * Functions
 */

// Include core library
require 'imscp-lib.php';

iMSCP_Events_Manager::getInstance()->dispatch(iMSCP_Events::onResellerScriptStart);

check_login('reseller');

/**
 * @var $cfg iMSCP_Config_Handler_File
 */
$cfg = iMSCP_Registry::get('config');

$tpl = new iMSCP_pTemplate();
$tpl->define_dynamic(
	array(
		'layout' => 'shared/layouts/ui.tpl',
		'page' => 'shared/partials/forms/hosting_plan_edit.tpl',
		'page_message' => 'layout',
		'subdomain_edit' => 'page',
		'alias_edit' => 'page',
		'mail_edit' => 'page',
		'ftp_edit' => 'page',
		'sql_db_edit' => 'page',
		'sql_user_edit' => 'page',
		'php_editor_js' => 'page',
		'php_editor_block' => 'page',
		'php_editor_permissions_block' => 'php_editor_block',
		'php_editor_allow_url_fopen_block' => 'php_editor_permissions_block',
		'php_editor_display_errors_block' => 'php_editor_permissions_block',
		'php_editor_disable_functions_block' => 'php_editor_permissions_block',
		'php_editor_default_values_block' => 'php_editor_block',
		't_software_support' => 'page',
		'submit_button' => 'page'
	)
);

if (isset($_GET['id'])) {
	global $id;
	$id = clean_input($_GET['id']);

	/* @var $phpini iMSCP_PHPini */
	$phpini = iMSCP_PHPini::getInstance();
	$phpini->loadRePerm($_SESSION['user_id']);

	if (!empty($_POST)) {
		if (isset($cfg->HOSTING_PLANS_LEVEL) && $cfg->HOSTING_PLANS_LEVEL == 'reseller') {
			if (checkInputData($phpini) && saveData($phpini)) {
				set_page_message(tr('Hosting plan successfully updated.'), 'success');
				redirectTo('hosting_plan.php');
			} else {
				generateErrorForm($tpl, $phpini);
			}
		} else {
			showBadRequestErrorPage();
		}
	} else {
		generateForm($tpl, $id, $_SESSION['user_id'], $phpini);
	}

	get_reseller_software_permission($tpl, $_SESSION['user_id']);

	generateNavigation($tpl);

	$tpl->assign(
		array(
			'THEME_CHARSET' => tr('encoding'),
			'TR_PAGE_TITLE' => $cfg->HOSTING_PLANS_LEVEL != 'reseller'
				? tr('i-MSCP - Reseller / Manage Hosting Plans / View hosting plan') :
				tr('i-MSCP - Reseller / Manage Hosting Plans / Edit hosting plan'),
			'ISP_LOGO' => layout_getUserLogo(),
			'TR_PROPERTIES' => tr('Hosting plan properties'),
			'TR_NAME' => tr('Name'),
			'TR_DESCRIPTON' => tr('Description'),
			'TR_MAX_SUB' => tr('Max subdomains<br/><i>(-1 disabled, 0 unlimited)</i>'),
			'TR_MAX_ALS' => tr('Max aliases<br/><i>(-1 disabled, 0 unlimited)</i>'),
			'TR_MAX_MAIL' => tr('Mail accounts limit<br/><i>(-1 disabled, 0 unlimited)</i>'),
			'TR_MAX_FTP' => tr('FTP accounts limit<br/><i>(-1 disabled, 0 unlimited)</i>'),
			'TR_MAX_SQLD' => tr('SQL databases limit<br/><i>(-1 disabled, 0 unlimited)</i>'),
			'TR_MAX_SQLU' => tr('SQL users limit<br/><i>(-1 disabled, 0 unlimited)</i>'),
			'TR_MONTHLY_TRAFFIC' => tr('Monthly traffic limit [MiB]<br/><i>(0 unlimited)</i>'),
			'TR_MAX_DISKSPACE' => tr('Disk space limit [MiB]<br/><i>(0 unlimited)</i>'),
			'TR_PHP' => tr('PHP'),
			'TR_CGI' => tr('CGI'),
			'TR_DNS' => tr('Custom DNS records'),
			'TR_BACKUP' => tr('Backup'),
			'TR_BACKUP_DOMAIN' => tr('Domain'),
			'TR_BACKUP_SQL' => tr('Sql'),
			'TR_BACKUP_FULL' => tr('Full'),
			'TR_BACKUP_NO' => tr('No'),
			'TR_SOFTWARE_SUPP' => tr('Software installer'),
			'TR_EXTMAIL' => tr('External mail server'),
			'TR_AVAILABILITY' => tr('Hosting plan availability'),
			'TR_STATUS' => tr('Available'),
			'TR_YES' => tr('yes'),
			'TR_NO' => tr('no'),
			'TR_UPDATE' => tr('Update'),
		)
	);

	generatePageMessage($tpl);

	if (!resellerHasFeature('subdomains')) $tpl->assign('SUBDOMAIN_ADD', '');
	if (!resellerHasFeature('domain_aliases')) $tpl->assign('ALIAS_ADD', '');
	if (!resellerHasFeature('mail')) $tpl->assign('MAIL_ADD', '');
	if (!resellerHasFeature('ftp')) $tpl->assign('FTP_ADD', '');
	if (!resellerHasFeature('sql_db')) $tpl->assign('SQL_DB_ADD', '');
	if (!resellerHasFeature('sql_user')) $tpl->assign('SQL_USER_ADD', '');

	$tpl->parse('LAYOUT_CONTENT', 'page');

	iMSCP_Events_Manager::getInstance()->dispatch(iMSCP_Events::onResellerScriptEnd, array('templateEngine' => $tpl));

	$tpl->prnt();
} else {
	showBadRequestErrorPage();
}
