<?php
ini_set('date.timezone', 'Europe/Lisbon');
date_default_timezone_set('Europe/Lisbon');

// Report no PHP errors
error_reporting(0);
ini_set('display_errors', 0);

$rulesFile = '/path/to/backend/rules.ini';
$defaultRule = 'rule_default';
$uniqid = uniqid();
$errorDisplayBeginHtml = "\n	<div class=\"container\">\n";
$errorDisplayEndHtml = "\n		</div>\n	</body>\n</html>\n";

$scriptMain = "			function errorHtml(type,html) {
				if ($('div.alert').length >= 1) {
					$('div.alert').alert('close');
				}
				return '<div style=\"position: fixed; top: 0px; left: 0px; width: 100%; z-index:9999; padding-bottom: 1rem; border-radius: 0px\" class=\"alert ' + type + ' alert-dismissible fade show\" role=\"alert\"><strong>! ERRO !</strong><br />' + html + '<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>';
			}
			function isValidUrl(url) {
				return /^(https?):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
			}";

function in_multiarray($elem, $array) {
	while (current($array) !== false) {
		if (current($array) == $elem) {
			return true;
		} elseif (is_array(current($array))) {
			if (in_multiarray($elem, current($array))) {
				return true;
			}
		}
		next($array);
	}
	return false;
}

header('Content-Type: text/html; charset=utf-8');
?>
<!doctype html>
<html lang="pt">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>Redirects & Proxies</title>

		<link rel="icon" href="/favicon.ico">

		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css" integrity="sha512-P5MgMn1jBN01asBgU0z60Qk4QxiXo86+wlFahKrsQf37c9cro517WzVSPPV1tDKzhku2iJ2FVgL67wG03SGnNA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap-grid.min.css" integrity="sha512-cKoGpmS4czjv58PNt1YTHxg0wUDlctZyp9KUxQpdbAft+XqnyKvDvcGX0QYCgCohQenOuyGSl8l1f7/+axAqyg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap-reboot.min.css" integrity="sha512-wV3xzHEw4kJUF4G0fyXSefKmUVhwwbOdZinJvOxmysxAXSZBl17porgPOcQBDBQTEwgGevxXGWAAQ/UPaSd0nw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

		<style id="css-<?php echo $uniqid; ?>"></style>

		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

		<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js" integrity="sha512-XKa9Hemdy1Ui3KSGgJdgMyYlUg1gM+QhL6cnlyTe2qzMCYm4nAZ1PsVerQzTTXzonUR+dmswHqgJPuwCq1MaAg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js" integrity="sha512-wV7Yj1alIZDqZFCUQJy85VN+qvEIly93fIQAN7iqDFCPEucLCeNFz4r35FCo9s6WrpdDQPi80xbljXB8Bjtvcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

		<script id="jvs-<?php echo $uniqid; ?>"></script>
	</head>
	<body>
		<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
			<span class="my-0 mr-md-auto">
				<h4 class="mt-0 mb-0 font-weight-bold">Example.com</h4>
				<h6 class="mt-0 mb-0">Redirects & Proxies</h6>
			</span>
<?php
if (!isset($_GET['edit']) && !isset($_GET['create'])) {
?>
				<form class="searchbar mr-md-2 my-2">
					<input type="search" id="search-input" placeholder="Pesquisa" name="search" class="form-control input-sm searchbar-input">
					<span class="searchbar-icon">
						<i style="padding: .65rem;" class="btn btn-primary mb-3 fa fa-search" role="button" aria-hidden="true"></i>
					</span>
				</form>
<?php
}
?>
			<a class="btn btn-primary<?php echo ((isset($_GET['create']) && empty($_GET['create'])) ? ' disabled" aria-disabled="true' : ''); ?>" role="button" href="?create">Novo</a>
		</div>
		<br />
<?php
if (isset($_GET['create']) && empty($_GET['create'])) {

	if ($_POST) {

		$rulesArray = parse_ini_file($rulesFile, true);

		# Check for existance of sourceDomain in a already configured rule
		$sourceDomainError = '';
		foreach ($_POST['domain'] as $domain) {
			if (in_multiarray($domain, array_column($rulesArray, 'sourceDomain'))) {
				$sourceDomainError .= 'The <i>'.$domain.'</i> doman is already in use!<br />';
			}
		}
		if (isset($sourceDomainError) && !empty($sourceDomainError)) {
			die($errorDisplayBeginHtml."<b>ERROR</b><br />".$sourceDomainError."Please make a search on the existing rules before adding the new one.".$errorDisplayEndHtml);
		}

		$randomId = ';---'.gmdate("YmdHis").'---'.uniqid().'---;';
		$newRule = $randomId."\r";

		# Status
		if (isset($_POST['status']) && in_array($_POST['status'], array(0,1))) {
			$newRule .= "enabled = \"".(boolval($_POST['status']) ? 'true' : 'false')."\"\r";
		} else {
			die($errorDisplayBeginHtml."<b>ERROR</b><br />Status is mandatory or the inserted value is invalid (".__LINE__.").".$errorDisplayEndHtml);
		}

		# Mode
		if (isset($_POST['mode']) && !empty($_POST['mode'])) {
			if ($_POST['mode'][0] === "r") {
				$guidMode = 'redirect';
				$newRule .= "mode = \"redirect,30".$_POST['mode'][1]."\"\r";
			} elseif ($_POST['mode'] === 'px') {
				$guidMode = 'rewrite';
				$newRule .= "mode = \"rewrite\"\r";
			} else {
				die($errorDisplayBeginHtml."<b>ERROR</b><br />Mode is mandatory or the inserted value is invalid (".__LINE__.").".$errorDisplayEndHtml);
			}
		} else {
			die($errorDisplayBeginHtml."<b>ERROR</b><br />Mode is mandatory or the inserted value is invalid (".__LINE__.").".$errorDisplayEndHtml);
		}

		# Proxy Timeouts
		# Proxy Connect Timeout
		$isProxyConnectTimeoutDefined =  false;
		if (isset($_POST['proxyConnectTimeout']) && !empty($_POST['proxyConnectTimeout']) && filter_var($_POST['proxyConnectTimeout'], FILTER_VALIDATE_INT) !== false) {
			$newRule .= "proxyConnectTimeout = \"".$_POST['proxyConnectTimeout']."\"\r";
			$isProxyConnectTimeoutDefined = true;
		}
		# Proxy Global Timeout
		$isProxyGlobalTimeoutDefined =  false;
		if (isset($_POST['proxyGlobalTimeout']) && !empty($_POST['proxyGlobalTimeout']) && filter_var($_POST['proxyGlobalTimeout'], FILTER_VALIDATE_INT) !== false) {
			if ($isProxyConnectTimeoutDefined && ($_POST['proxyConnectTimeout'] >= $_POST['proxyGlobalTimeout'])) {
				die($errorDisplayBeginHtml."<b>ERROR</b><br />Proxy settings Global Timeout value must be higher than Connect Timeout (".__LINE__.").".$errorDisplayEndHtml);
			}
			$newRule .= "proxyGlobalTimeout = \"".$_POST['proxyGlobalTimeout']."\"\r";
			$isProxyGlobalTimeoutDefined =  true;
		}
		# Other validations
		if ($_POST['mode'] !== 'px' && ($isProxyConnectTimeoutDefined && $isProxyGlobalTimeoutDefined)) {
			die($errorDisplayBeginHtml."<b>ERROR</b><br />Proxy settings defined but no Mode Proxy was choosed (".__LINE__.").".$errorDisplayEndHtml);
		}
		if ($isProxyConnectTimeoutDefined && !$isProxyGlobalTimeoutDefined) {
			die($errorDisplayBeginHtml."<b>ERROR</b><br />Proxy settings Global Timeout value must be defined when Connect Timeout is defined (".__LINE__.").".$errorDisplayEndHtml);
		}
		# /Proxy Timeouts

		# Domains
		if (isset($_POST['domain']) && (count($_POST['domain']) >= 1 && !empty($_POST['domain'][0]))) {
			foreach ($_POST['domain'] as $value) {
				$newRule .= "sourceDomain[] = \"".trim($value)."\"\r";
			}
		} else {
			die($errorDisplayBeginHtml."<b>ERROR</b><br />Domains are mandatory, must have at least one or the inserted value is invalid (".__LINE__.").".$errorDisplayEndHtml);
		}

		# Match URL
		if (isset($_POST['matchUrl']) && !empty($_POST['matchUrl'])) {
			$newRule .= "matchUrl = \"".$_POST['matchUrl']."\"\r";
		} else {
			die($errorDisplayBeginHtml."<b>ERROR</b><br />Match URL is mandatory or the inserted value is invalid (".__LINE__.").".$errorDisplayEndHtml);
		}

		# Destination URL
		if (isset($_POST['destinationUrl']) && (filter_var($_POST['destinationUrl'], FILTER_VALIDATE_URL) !== false)) {
			$newRule .= "destinationUrl = \"".$_POST['destinationUrl']."\"\r";
		} else {
			die($errorDisplayBeginHtml."<b>ERROR</b><br />Destination URL is mandatory or the inserted value is invalid (".__LINE__.").".$errorDisplayEndHtml);
		}

		# Append match URL
		if (isset($_POST['appendMatchUrl']) && in_array($_POST['appendMatchUrl'], array(0,1))) {
			$newRule .= "appendMatchUrlToDestinationUrl = \"".(boolval($_POST['appendMatchUrl']) ? 'true' : 'false')."\"\r";
		} else {
			die($errorDisplayBeginHtml."<b>ERROR</b><br />Append Matched URL is mandatory or the inserted value is invalid (".__LINE__.").".$errorDisplayEndHtml);
		}

		# Append query string
		if (isset($_POST['appendQueryString']) && in_array($_POST['appendQueryString'], array(0,1))) {
			$newRule .= "appendQueryStringToDestinationUrl = \"".(boolval($_POST['appendQueryString']) ? 'true' : 'false')."\"\r";
		} else {
			die($errorDisplayBeginHtml."<b>ERROR</b><br />Append Query String is mandatory or the inserted value is invalid (".__LINE__.").".$errorDisplayEndHtml);
		}

		# Force HTTPS
		if (isset($_POST['forceHttps']) && $_POST['forceHttps'] == 1) {
			$newRule .= "forceHttps = \"".(boolval($_POST['forceHttps']) ? 'true' : 'false')."\"\r";
		}

		$newRule .= "logRule = \"".(isset($_POST['logRule']) ? (boolval($_POST['logRule']) ? 'true' : 'false') : 'false')."\"\r";
		$newRule .= "debug = \"".(isset($_POST['debug']) ? (boolval($_POST['debug']) ? 'true' : 'false') : 'false')."\"\r\r";

		# Generate guid
		$guid = 'rule_'.str_replace(".", "-", trim($_POST['domain'][0])).'_'.$guidMode;

		# Replace randomId writed before by guid and create "rule header"
		$newRule = str_replace($randomId, "; created at ".gmdate('Y-m-d H:i:s')."\r[".$guid."]", $newRule);

		$currentRulesTxt = file_get_contents($rulesFile);

		# Make backup
		if (!copy($rulesFile, $rulesFile.'.'.gmdate('YmdHis').'.BACKUP.txt')) {
			die($errorDisplayBeginHtml."<b>ERROR</b><br />Unable to make backup of current rules file (".__LINE__.").".$errorDisplayEndHtml);
		}

		# Write new content
		if (is_writable($rulesFile)) {
			$fh = fopen($rulesFile, 'w') or die($errorDisplayBeginHtml."<b>ERROR</b><br />Unable to open rules file (".__LINE__.").".$errorDisplayEndHtml);
			if (fwrite($fh, $newRule . $currentRulesTxt) === FALSE) {
				$fwriteError = $errorDisplayBeginHtml."<b>ERROR</b><br />Unable to write to rules file (".__LINE__.").".$errorDisplayEndHtml;
			}
			fclose($fh);
		} else {
			die($errorDisplayBeginHtml."<b>ERROR</b><br />The rules file is not writable (".__LINE__.").".$errorDisplayEndHtml);
		}

		if (isset($fwriteError) && !empty($fwriteError)) {
			die($fwriteError);
		}

		unset($currentRulesTxt);

		header("Location: ./#".$guid,TRUE,301);

	} else {

		$style = "
			.btn-header-link:after {
				content: \"\\00a0\\f106\";
				font-family: 'Font Awesome 5 Free';
				font-weight: 900;
				float: right;
			}
			.btn-header-link.collapsed:after {
				content: \"\\00a0\\f107\";
			}
		";
		$script = "

		function isNumberKey(evt) {
			var charCode = (evt.which) ? evt.which : evt.keyCode;
			if (charCode != 46 && charCode > 31 
			&& (charCode < 48 || charCode > 57))
			return false;
			return true;
		}

		$(document).ready(function() {
".$scriptMain."
			$('form').on('submit', function(event) {
				event.preventDefault();
				$('form').append($('<input>').attr('type', 'hidden').attr('name', 'ruleGuid').val($('#rG').text()));
				this.submit();
			});
			$(\"button#addSourceDomain\").click(function(e){
				e.preventDefault();
				$('div#domains').append($('div#domain').get(0).outerHTML).html();
				$('div#domain input').last().val('');
			});
			$(document).on('click', 'button#deleteSourceDomain', function (e) {
				e.preventDefault();
				if ($('div#domain').length > 1) {
					$(this).closest('div#domain').remove();
				} else {
					var html = 'É obrigatório definir pelo menos 1 domínio(s).';
					$('body').prepend(errorHtml('alert-danger',html));
				}
			});
			$('#destinationUrl').on('change keyup paste', function () {
				var url = $('#destinationUrl').val();
				if (isValidUrl(url)) {
					$('a#destinationUrlTest').attr('href', url);
					$('a#destinationUrlTest').attr('target', '_blank');
				} else {
					$('a#destinationUrlTest').removeAttr('href');
					$('a#destinationUrlTest').removeAttr('target');
				}
			});
			$('#mode').on('change', function () {
				if ($('#mode').val() == 'px') {
					$('#opcoesAvancadasDiv').show('slow');
					$('#opcoesAvancadasDiv :input').removeAttr('disabled');
				} else {
					$('#opcoesAvancadasDiv').hide('slow', function(){
						$('.btn-header-link').addClass('collapsed');
						$('#opcoesAvancadas').removeClass('show');
					});
					$('#opcoesAvancadasDiv :input').val('');
					$('#opcoesAvancadasDiv :input').attr('disabled','disabled');
				}
			});
			var autoSetGlobalTimeout = false;
			$('#opcoesAvancadasDiv :input').on('change', function() {
				if ($('#opcoesAvancadasDiv').is(':visible')) {
					if (($('#proxyConnectTimeout').val() != '' || Number($('#proxyConnectTimeout').val()) > 0) && (Number($('#proxyConnectTimeout').val()) >= Number($('#proxyGlobalTimeout').val()))) {
						$('#proxyGlobalTimeout').val(+$('#proxyConnectTimeout').val()+1);
						autoSetGlobalTimeout = true;
					} else if ($('#proxyConnectTimeout').val() == '' || Number($('#proxyConnectTimeout').val()) <= 0) {
						if (autoSetGlobalTimeout == true) {
							$('#proxyGlobalTimeout').val('');
							autoSetGlobalTimeout = false;
						}
						$('#proxyConnectTimeout').val('');
					} else {
						$(':input[type=\"submit\"]').removeAttr('disabled');
						autoSetGlobalTimeout = false;
					}
				}
			});
		});

		";

		if (isset($style) && !empty($style)) {
?>
		<script type="text/javascript">
			//<![CDATA[
				document.getElementById('css-<?php echo $uniqid; ?>').innerHTML = <?php echo json_encode($style); ?>;
			//]]>
		</script>
<?php
		}
		if (isset($script) && !empty($script)) {
?>
		<script type="text/javascript">
			//<![CDATA[
				document.getElementById('jvs-<?php echo $uniqid; ?>').innerHTML = <?php echo json_encode($script); ?>;
			//]]>
		</script>
<?php
		}
?>
		<div class="container">
			<form method="post">
				<div class="form-group row">
					<legend for="status" class="col-form-label col-sm-2 text-right">Estado</legend>
					<div class="col-sm-10">
						<select class="form-control" name="status" id="status">
							<option disabled selected hidden>Seleccione um valor</option>
							<option value="1">Activa</option>
							<option value="0">Inactiva</option>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label for="mode" class="col-sm-2 col-form-label text-right">Modo</label>
					<div class="col-sm-10">
						<select class="form-control" name="mode" id="mode">
							<option disabled selected hidden>Seleccione um valor</option>
							<option value="r1">Redirect Permanently (301)</option>
							<option value="r2">Redirect Found (302)</option>
							<option value="r3">Redirect See Other (303)</option>
							<option value="px">Proxy</option>
						</select>
					</div>
				</div>
				<div class="form-group row" style="display: none; visible: hidden;" id="opcoesAvancadasDiv">
					<div class="col-sm-12">
						<a href="#" class="btn btn-warning btn-header-link collapsed font-weight-bold float-right" data-toggle="collapse" data-target="#opcoesAvancadas" aria-expanded="false" aria-controls="opcoesAvancadas">Opções avançadas</a>
					</div>
					<div class="col-sm-12">
						<div class="col-sm-10 collapse bg-warning text-dark mt-3 pl-4 p-3 pr-4 rounded float-right" id="opcoesAvancadas">
							<div class="form-group row">
								<div class="col-sm-12 text-center font-weight-bold">Proxy settings</div>
							</div>
							<div class="form-group row">
								<label for="proxyConnectTimeout" class="col-sm-2 col-form-label pr-0 text-right">Connect Timeout</label>
								<div class="col-sm-9 pr-2">
									<input type="text" class="form-control" onkeypress="return isNumberKey(event)" disabled="disabled" name="proxyConnectTimeout" id="proxyConnectTimeout">
								</div>
								<div class="col-sm-1 pl-0 pt-1 text-left">seg.</div>
							</div>
							<div class="form-group row">
								<label for="proxyGlobalTimeout" class="col-sm-2 col-form-label pr-0 text-right">Global Timeout</label>
								<div class="col-sm-9 pr-2">
									<input type="text" class="form-control" onkeypress="return isNumberKey(event)" disabled="disabled" name="proxyGlobalTimeout" id="proxyGlobalTimeout">
								</div>
								<div class="col-sm-1 pl-0 pt-1 text-left">seg.</div>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<label for="domains" class="col-sm-2 col-form-label text-right">Domínios</label>
					<div id="domains" class="col-sm-10">
						<div id="domain" class="d-inline">
							<input type="text" class="col-10 col-md-5 form-control d-inline mb-1" name="domain[]">
							<button id="deleteSourceDomain" class="btn btn-sm btn-secondary pt-0 text-center align-middle mb-1 mb-md-2 mr-md-3">
								<strong>-</strong>
							</button>
						</div>
					</div>
					<div class="col-sm-12 pb-2">
						<button id="addSourceDomain" class="btn btn-sm btn-secondary pt-0 text-center float-right">
							<strong>+</strong>
						</button>
					</div>
				</div>
				<div class="form-group row">
					<label for="matchUrl" class="col-sm-2 col-form-label text-right">Url de origem</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="matchUrl" id="matchUrl">
					</div>
				</div>
				<div class="form-group row">
					<label for="destinationUrl" class="col-sm-2 col-form-label text-right">Url de destino</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" name="destinationUrl" id="destinationUrl">
					</div>
					<div class="col-sm-1 pt-1">
						<a id="destinationUrlTest" class="font-weight-bold">testar</a>
					</div>
				</div>
				<div class="form-group row">
					<legend for="appendMatchUrl" class="col-form-label col-sm-2 text-right">Adicionar <span class="font-italic">relative path</span></legend>
					<div class="col-sm-10">
						<select class="form-control" name="appendMatchUrl" id="appendMatchUrl">
							<option disabled selected hidden>Seleccione um valor</option>
							<option value="1">Activo</option>
							<option value="0">Inactivo</option>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<legend for="appendQueryString" class="col-form-label col-sm-2 text-right">Adicionar <span class="font-italic">query string</span></legend>
					<div class="col-sm-10">
						<select class="form-control" name="appendQueryString" id="appendQueryString">
							<option disabled selected hidden>Seleccione um valor</option>
							<option value="1">Activo</option>
							<option value="0">Inactivo</option>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<legend for="forceHttps" class="col-form-label col-sm-2 text-right">Forçar HTTPS</legend>
					<div class="col-sm-10">
						<select class="form-control" name="forceHttps" id="forceHttps">
							<option disabled selected hidden>Seleccione um valor</option>
							<option value="1">Activo</option>
							<option value="0">Inactivo</option>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label for="log" class="col-sm-2 col-form-label text-right">Log</label>
					<div class="col-sm-10">
						<select class="form-control btn-light disabled" name="log" id="log" disabled>
							<option disabled selected hidden>Seleccione um valor</option>
							<option value="1">Activo</option>
							<option value="0">Inactivo</option>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label for="debug" class="col-sm-2 col-form-label text-right">Debug</label>
					<div class="col-sm-10">
						<select class="form-control btn-light disabled" name="debug" id="debug" disabled>
							<option disabled selected hidden>Seleccione um valor</option>
							<option value="1">Activo</option>
							<option value="0">Inactivo</option>
						</select>
					</div>
				</div>
				<div class="form-group pt-1">
					<input class="btn btn-primary float-right" type="submit" value="Gravar">
				</div>
			</form>
		</div><!-- /container -->
		<br />
		<br />
<?php
	}

} elseif (isset($_GET['edit']) && !empty($_GET['edit']) && preg_match('/^[\w-.]+$/', $_GET['edit'])) {

	ini_set("auto_detect_line_endings", true);

	if ($_POST) {

		# Guid
		if (isset($_GET['edit']) && isset($_POST['ruleGuid']) && $_GET['edit'] === $_POST['ruleGuid']) {
			$editedRule = ";  edited at ".gmdate('Y-m-d H:i:s')."\r[".$_GET['edit']."]\r";
		} else {
			die($errorDisplayBeginHtml."<b>ERROR</b><br />Guid is mandatory or the inserted value is invalid (".__LINE__.").".$errorDisplayEndHtml);
		}

		# Status
		if (isset($_POST['status']) && in_array($_POST['status'], array(0,1))) {
			$editedRule .= "enabled = \"".(boolval($_POST['status']) ? 'true' : 'false')."\"\r";
		} else {
			die($errorDisplayBeginHtml."<b>ERROR</b><br />Status is mandatory or the inserted value is invalid (".__LINE__.").".$errorDisplayEndHtml);
		}

		# Mode
		if (isset($_POST['mode']) && !empty($_POST['mode'])) {
			if ($_POST['mode'][0] === "r") {
				$editedRule .= "mode = \"redirect,30".$_POST['mode'][1]."\"\r";
			} elseif ($_POST['mode'] === 'px') {
				$editedRule .= "mode = \"rewrite\"\r";
			} else {
				die($errorDisplayBeginHtml."<b>ERROR</b><br />Mode is mandatory or the inserted value is invalid (".__LINE__.").".$errorDisplayEndHtml);
			}
		} else {
			die($errorDisplayBeginHtml."<b>ERROR</b><br />Mode is mandatory or the inserted value is invalid (".__LINE__.").".$errorDisplayEndHtml);
		}

		# Proxy Timeouts
		# Proxy Connect Timeout
		$isProxyConnectTimeoutDefined =  false;
		if (isset($_POST['proxyConnectTimeout']) && !empty($_POST['proxyConnectTimeout']) && filter_var($_POST['proxyConnectTimeout'], FILTER_VALIDATE_INT) !== false) {
			$editedRule .= "proxyConnectTimeout = \"".$_POST['proxyConnectTimeout']."\"\r";
			$isProxyConnectTimeoutDefined = true;
		}
		# Proxy Global Timeout
		$isProxyGlobalTimeoutDefined =  false;
		if (isset($_POST['proxyGlobalTimeout']) && !empty($_POST['proxyGlobalTimeout']) && filter_var($_POST['proxyGlobalTimeout'], FILTER_VALIDATE_INT) !== false) {
			if ($isProxyConnectTimeoutDefined && ($_POST['proxyConnectTimeout'] >= $_POST['proxyGlobalTimeout'])) {
				die($errorDisplayBeginHtml."<b>ERROR</b><br />Proxy settings Global Timeout value must be higher than Connect Timeout (".__LINE__.").".$errorDisplayEndHtml);
			}
			$editedRule .= "proxyGlobalTimeout = \"".$_POST['proxyGlobalTimeout']."\"\r";
			$isProxyGlobalTimeoutDefined =  true;
		}
		# Other validations
		if ($_POST['mode'] !== 'px' && ($isProxyConnectTimeoutDefined && $isProxyGlobalTimeoutDefined)) {
			die($errorDisplayBeginHtml."<b>ERROR</b><br />Proxy settings defined but no Mode Proxy was choosed (".__LINE__.").".$errorDisplayEndHtml);
		}
		if ($isProxyConnectTimeoutDefined && !$isProxyGlobalTimeoutDefined) {
			die($errorDisplayBeginHtml."<b>ERROR</b><br />Proxy settings Global Timeout value must be defined when Connect Timeout is defined (".__LINE__.").".$errorDisplayEndHtml);
		}
		# /Proxy Timeouts

		# Domains
		if (isset($_POST['domain']) && (!empty($_POST['domain']) || count($_POST['domain']) >= 1)) {
			foreach ($_POST['domain'] as $value) {
				$editedRule .= "sourceDomain[] = \"".trim($value)."\"\r";
			}
		} else {
			die($errorDisplayBeginHtml."<b>ERROR</b><br />Domains are mandatory, must have at least one or the inserted value is invalid (".__LINE__.").".$errorDisplayEndHtml);
		}

		# Match URL
		if (isset($_POST['matchUrl']) && !empty($_POST['matchUrl'])) {
			$editedRule .= "matchUrl = \"".$_POST['matchUrl']."\"\r";
		} else {
			die($errorDisplayBeginHtml."<b>ERROR</b><br />Match URL is mandatory or the inserted value is invalid (".__LINE__.").".$errorDisplayEndHtml);
		}

		# Destination URL
		if (isset($_POST['destinationUrl']) && (filter_var($_POST['destinationUrl'], FILTER_VALIDATE_URL) !== false)) {
			$editedRule .= "destinationUrl = \"".$_POST['destinationUrl']."\"\r";
		} else {
			die($errorDisplayBeginHtml."<b>ERROR</b><br />Destination URL is mandatory or the inserted value is invalid (".__LINE__.").".$errorDisplayEndHtml);
		}

		# Append match URL
		if (isset($_POST['appendMatchUrl']) && in_array($_POST['appendMatchUrl'], array(0,1))) {
			$editedRule .= "appendMatchUrlToDestinationUrl = \"".(boolval($_POST['appendMatchUrl']) ? 'true' : 'false')."\"\r";
		} else {
			die($errorDisplayBeginHtml."<b>ERROR</b><br />Append Matched URL is mandatory or the inserted value is invalid (".__LINE__.").".$errorDisplayEndHtml);
		}

		# Append query string
		if (isset($_POST['appendQueryString']) && in_array($_POST['appendQueryString'], array(0,1))) {
			$editedRule .= "appendQueryStringToDestinationUrl = \"".(boolval($_POST['appendQueryString']) ? 'true' : 'false')."\"\r";
		} else {
			die($errorDisplayBeginHtml."<b>ERROR</b><br />Append Query String is mandatory or the inserted value is invalid (".__LINE__.").".$errorDisplayEndHtml);
		}

		# Force HTTPS
		if (isset($_POST['forceHttps']) && $_POST['forceHttps'] == 1) {
			$editedRule .= "forceHttps = \"".(boolval($_POST['forceHttps']) ? 'true' : 'false')."\"\r";
		}

		$editedRule .= "logRule = \"".(isset($_POST['logRule']) ? (boolval($_POST['logRule']) ? 'true' : 'false') : 'false')."\"\r";
		$editedRule .= "debug = \"".(isset($_POST['debug']) ? (boolval($_POST['debug']) ? 'true' : 'false') : 'false')."\"";

		$i = 0;
		$currentRulesFileTxt = '';
		$randomId = ';---'.gmdate("YmdHis").'---'.uniqid().'---;';

		$file = new SplFileObject($rulesFile, 'r');
		foreach ($file as $lineNum => $lineTxt) {
			if (($lineNum+1) >= $_POST['ruleBeginLine'] && ($lineNum+1) <= $_POST['ruleEndLine']) {
				if ($i === 0) {
					$currentRulesFileTxt .= $randomId."\r\r";
				}
				$i++;
			} else {
				$currentRulesFileTxt .= $lineTxt;
			}
		}
		$file = null;

		# Check for existance of sourceDomain in a already configured rule
		$sourceDomainError = '';
		preg_match_all('/sourceDomain\[\]\s=\s\"(.+?)\"/s', $currentRulesFileTxt, $currentRulesFileSourceDomainsArray);
		foreach ($_POST['domain'] as $domain) {
			if (in_array($domain, $currentRulesFileSourceDomainsArray[1])) {
				$sourceDomainError .= 'The <i>'.$domain.'</i> doman is already in use!<br />';
			}
		}
		if (isset($sourceDomainError) && !empty($sourceDomainError)) {
			die($errorDisplayBeginHtml."<b>ERROR</b><br />".$sourceDomainError."Please make a search on the existing rules before adding the new one.".$errorDisplayEndHtml);
		}

		# Replace randomId writed before by editedRule
		$newRulesFileTxt = str_replace($randomId."\r", $editedRule, $currentRulesFileTxt);

		# Make backup
		if (!copy($rulesFile, $rulesFile.'.'.gmdate('YmdHis').'.BACKUP.txt')) {
			die($errorDisplayBeginHtml."<b>ERROR</b><br />Unable to make backup of current rules file (".__LINE__.").".$errorDisplayEndHtml);
		}

		# Write new content
		if (is_writable($rulesFile)) {
			$fh = fopen($rulesFile, 'w') or die($errorDisplayBeginHtml."<b>ERROR</b><br />Unable to open rules file (".__LINE__.").".$errorDisplayEndHtml);
			if (fwrite($fh, $newRulesFileTxt) === FALSE) {
				$fwriteError = $errorDisplayBeginHtml."<b>ERROR</b><br />Unable to write to rules file (".__LINE__.").".$errorDisplayEndHtml;
			}
			fclose($fh);
		} else {
			die($errorDisplayBeginHtml."<b>ERROR</b><br />The rules file is not writable (".__LINE__.").".$errorDisplayEndHtml);
		}

		if (isset($fwriteError) && !empty($fwriteError)) {
			die($fwriteError);
		}

		# Sync rules file to other servers

		header("Location: ./#".$_POST['ruleGuid'],TRUE,301);
	
	} else {

		$style = "
			.btn-header-link:after {
				content: \"\\00a0\\f106\";
				font-family: 'Font Awesome 5 Free';
				font-weight: 900;
				float: right;
			}
			.btn-header-link.collapsed:after {
				content: \"\\00a0\\f107\";
			}
		";
		$script = "

		function isNumberKey(evt) {
			var charCode = (evt.which) ? evt.which : evt.keyCode;
			if (charCode != 46 && charCode > 31 
			&& (charCode < 48 || charCode > 57))
			return false;
			return true;
		}

		$(document).ready(function() {
".$scriptMain."
			$('form').on('submit', function(event) {
				event.preventDefault();
				$('form').append($('<input>').attr('type', 'hidden').attr('name', 'ruleGuid').val($('#rG').text()));
				$('form').append($('<input>').attr('type', 'hidden').attr('name', 'ruleBeginLine').val($('#rBL').text()));
				$('form').append($('<input>').attr('type', 'hidden').attr('name', 'ruleEndLine').val($('#rEL').text()));
				this.submit();
			});
			$(\"button#addSourceDomain\").click(function(e){
				e.preventDefault();
				$('div#domains').append($('div#domain').get(0).outerHTML).html();
				$('div#domain input').last().val('');
			});
			$(document).on('click', 'button#deleteSourceDomain', function (e) {
				e.preventDefault();
				if ($('div#domain').length > 1) {
					$(this).closest('div#domain').remove();
				} else {
					var html = 'É obrigatório definir pelo menos 1 domínio(s).';
					$('body').prepend(errorHtml('alert-danger',html));
				}
			});
			$('#mode').on('change', function () {
				if ($('#mode').val() == 'px') {
					$('#opcoesAvancadasDiv').show('slow');
					$('#opcoesAvancadasDiv :input').removeAttr('disabled');
				} else {
					$('#opcoesAvancadasDiv').hide('slow', function(){
						$('.btn-header-link').addClass('collapsed');
						$('#opcoesAvancadas').removeClass('show');
					});
					//$('#opcoesAvancadasDiv :input').val('');
					//$('#opcoesAvancadasDiv :input').attr('disabled','disabled');
				}
			});
			var autoSetGlobalTimeout = false;
			$('#opcoesAvancadasDiv :input').on('change', function() {
				if ($('#opcoesAvancadasDiv').is(':visible')) {
					if (($('#proxyConnectTimeout').val() != '' || Number($('#proxyConnectTimeout').val()) > 0) && (Number($('#proxyConnectTimeout').val()) >= Number($('#proxyGlobalTimeout').val()))) {
						$('#proxyGlobalTimeout').val(+$('#proxyConnectTimeout').val()+1);
						autoSetGlobalTimeout = true;
					} else if ($('#proxyConnectTimeout').val() == '' || Number($('#proxyConnectTimeout').val()) <= 0) {
						if (autoSetGlobalTimeout == true) {
							$('#proxyGlobalTimeout').val('');
							autoSetGlobalTimeout = false;
						}
						$('#proxyConnectTimeout').val('');
					} else {
						$(':input[type=\"submit\"]').removeAttr('disabled');
						autoSetGlobalTimeout = false;
					}
				}
			});
		});

		";

		$i = 0;
		$rule = array();
		$ruleBegin = false;
		$ruleBeginLine = 0;
		$ruleEnd = false;
		$ruleEndLine = 0;

		$fh = fopen($rulesFile, 'r') or die($errorDisplayBeginHtml."<b>ERROR</b><br />Unable to open rules file (".__LINE__.").".$errorDisplayEndHtml);
		while (!feof($fh)) {
			$line = fgets($fh, 1024);
			if (!preg_match('/\[' . $defaultRule . '\]/', $line) && $ruleEnd == false) {
				if (preg_match('/\['.$_GET['edit'].'\]/', $line)) {
					$ruleBegin = true;
					$ruleBeginLine = ($i+1);
					$rule[ ] = $line;
				} elseif (preg_match('/.+=.+/', $line) && ($ruleBegin == true && $ruleEnd == false)) {
					$rule[ ] = $line;
				} elseif (preg_match('/[\r\n\r\n|\n\n|\r\r]/', $line) && $ruleBegin == true) {
					$ruleEnd = true;
					$ruleEndLine = $i;
				}
			}
			$i++;
		}
		fclose($fh);

		if (isset($style) && !empty($style)) {
?>
		<script type="text/javascript">
			//<![CDATA[
				document.getElementById('css-<?php echo $uniqid; ?>').innerHTML = <?php echo json_encode($style); ?>;
			//]]>
		</script>
<?php
		}
		if (isset($script) && !empty($script)) {
?>
		<script type="text/javascript">
			//<![CDATA[
				document.getElementById('jvs-<?php echo $uniqid; ?>').innerHTML = <?php echo json_encode($script); ?>;
			//]]>
		</script>
<?php
		}
?>
		<div class="container">
			<h5 id="rG" class="my-0 font-weight-bold"><?php echo $_GET['edit']; ?></h5>
			<small>
				<div class="row pt-1">
					<div class="col-5 col-md-2">Início na linha</div>
					<div id="rBL" class="col-2"><?php echo $ruleBeginLine; ?></div>
				</div>
				<div class="row pb-3">
					<div class="col-5 col-md-2">Fim na linha</div>
					<div id="rEL" class="col-2"><?php echo $ruleEndLine; ?></div>
				</div>
			</small>
			<form method="post">
<?php
		if (!preg_match('/^' . $defaultRule . '$/', $rule[0])) {

			$isDomain = 0;

			// find all sourceDomain[] in this rule
			$matchesSourceDomainAll = preg_grep ('/sourceDomain\[\]/i', $rule);
			// find all ;sourceDomain[] in this rule
			$matchesSourceDomainComments  = preg_grep ('/;sourceDomain\[\]/i', $rule);
			// and make calculations on counts to use later bellow
			$totalSourceDomains = (count($matchesSourceDomainAll) - count($matchesSourceDomainComments));

			// find forceHttps in this rule
			$matchesForceHttps  = preg_grep ('/forceHttps/i', $rule);
			// if not exists append to array at 3rd position from end
			if (empty(count($matchesForceHttps))) {
				array_splice($rule, -2, 0, 'forceHttps = "false"');
			}

			foreach($rule as $ruleKey => $ruleValue) {

				if (!preg_match('/\['.$_GET['edit'].'\]/', $ruleValue)) {

					$line = explode('=', $ruleValue, 2);

					if (trim($line[0]) == 'enabled') {
?>
				<div class="form-group row">
					<legend for="status" class="col-form-label col-sm-2 text-right">Estado</legend>
					<div class="col-sm-10">
						<select class="form-control" name="status" id="status">
							<option value="1"<?php echo ((str_replace('"', '', trim($line[1])) == 'true') ? ' selected' : ''); ?>>Activa</option>
							<option value="0"<?php echo ((str_replace('"', '', trim($line[1])) == 'false') ? ' selected' : ''); ?>>Inactiva</option>
						</select>
					</div>
				</div>
<?php
					} elseif (trim($line[0]) == 'mode') {
?>
				<div class="form-group row">
					<label for="mode" class="col-sm-2 col-form-label text-right">Modo</label>
					<div class="col-sm-10">
						<select class="form-control" name="mode" id="mode">
							<option value="r1"<?php echo ((str_replace('"', '', trim($line[1])) == 'redirect,301') ? ' selected' : ''); ?>>Redirect Permanently (301)</option>
							<option value="r2"<?php echo ((str_replace('"', '', trim($line[1])) == 'redirect,302' || str_replace('"', '', trim($line[1])) == 'redirect') ? ' selected' : ''); ?>>Redirect Found (302)</option>
							<option value="r3"<?php echo ((str_replace('"', '', trim($line[1])) == 'redirect,303') ? ' selected' : ''); ?>>Redirect See Other (303)</option>
							<option value="px"<?php echo ((str_replace('"', '', trim($line[1])) == 'rewrite') ? ' selected' : ''); ?>>Proxy</option>
						</select>
					</div>
				</div>
<?php
						$htmlProxyAdvancedConfigs = "
				<div class=\"form-group row\"" . ((str_replace('"', '', trim($line[1])) != 'rewrite') ? ' style="display: none; visible: hidden;"' : '') . " id=\"opcoesAvancadasDiv\">
					<div class=\"col-sm-12\">
						<a href=\"#\" class=\"btn btn-warning btn-header-link collapsed font-weight-bold float-right\" data-toggle=\"collapse\" data-target=\"#opcoesAvancadas\" aria-expanded=\"false\" aria-controls=\"opcoesAvancadas\">Opções avançadas</a>
					</div>
					<div class=\"col-sm-12\">
						<div class=\"col-sm-10 collapse bg-warning text-dark mt-3 pl-4 p-3 pr-4 rounded float-right\" id=\"opcoesAvancadas\">
							<div class=\"form-group row\">
								<div class=\"col-sm-12 text-center font-weight-bold\">Proxy settings</div>
							</div>
							<div class=\"form-group row\">
								<label for=\"proxyConnectTimeout\" class=\"col-sm-2 col-form-label pr-0 text-right\">Connect Timeout</label>
								<div class=\"col-sm-9 pr-2\">
									<input type=\"text\" class=\"form-control\" onkeypress=\"return isNumberKey(event)\"" . ((str_replace('"', '', trim($line[1])) != 'rewrite') ? ' disabled="disabled"' : '') . " value=\"\" name=\"proxyConnectTimeout\" id=\"proxyConnectTimeout\">
								</div>
								<div class=\"col-sm-1 pl-0 pt-1 text-left\">seg.</div>
							</div>
							<div class=\"form-group row\">
								<label for=\"proxyGlobalTimeout\" class=\"col-sm-2 col-form-label pr-0 text-right\">Global Timeout</label>
								<div class=\"col-sm-9 pr-2\">
									<input type=\"text\" class=\"form-control\" onkeypress=\"return isNumberKey(event)\"" . ((str_replace('"', '', trim($line[1])) != 'rewrite') ? ' disabled="disabled"' : '') . " value=\"\" name=\"proxyGlobalTimeout\" id=\"proxyGlobalTimeout\">
								</div>
								<div class=\"col-sm-1 pl-0 pt-1 text-left\">seg.</div>
							</div>
						</div>
					</div>
				</div>";

					} elseif (trim($line[0]) == 'proxyConnectTimeout') {

						$proxyConnectTimeoutValue = intval(str_replace('"', '', trim($line[1])));

						$htmlProxyAdvancedConfigs = str_replace("btn-header-link collapsed", "btn-header-link", $htmlProxyAdvancedConfigs);
						$htmlProxyAdvancedConfigs = str_replace("float-right\" id=\"opcoesAvancadas\"", "float-right show\" id=\"opcoesAvancadas\"", $htmlProxyAdvancedConfigs);
						if (filter_var($proxyConnectTimeoutValue, FILTER_VALIDATE_INT) !== false) {
							$htmlProxyAdvancedConfigs = str_replace("value=\"\" name=\"proxyConnectTimeout\"", "value=\"" . $proxyConnectTimeoutValue . "\" name=\"proxyConnectTimeout\"", $htmlProxyAdvancedConfigs);
						} else {
							$htmlProxyAdvancedConfigs = str_replace("value=\"\" name=\"proxyConnectTimeout\"", "name=\"proxyConnectTimeout\"", $htmlProxyAdvancedConfigs);
						}

					} elseif (trim($line[0]) == 'proxyGlobalTimeout') {

						$proxyGlobalTimeoutValue = intval(str_replace('"', '', trim($line[1])));

						$htmlProxyAdvancedConfigs = str_replace("btn-header-link collapsed", "btn-header-link", $htmlProxyAdvancedConfigs);
						$htmlProxyAdvancedConfigs = str_replace("float-right\" id=\"opcoesAvancadas\"", "float-right show\" id=\"opcoesAvancadas\"", $htmlProxyAdvancedConfigs);
						if (filter_var($proxyGlobalTimeoutValue, FILTER_VALIDATE_INT) !== false) {
							$htmlProxyAdvancedConfigs = str_replace("value=\"\" name=\"proxyGlobalTimeout\"", "value=\"" . $proxyGlobalTimeoutValue . "\" name=\"proxyGlobalTimeout\"", $htmlProxyAdvancedConfigs);
						} else {
							$htmlProxyAdvancedConfigs = str_replace("value=\"\" name=\"proxyGlobalTimeout\"", "name=\"proxyGlobalTimeout\"", $htmlProxyAdvancedConfigs);
						}

					} elseif (trim($line[0]) == 'sourceDomain[]') {

						if ($isDomain == 0) {

							echo $htmlProxyAdvancedConfigs;
?>
				<div class="form-group row">
					<label for="domains" class="col-sm-2 col-form-label text-right">Domínios</label>
					<div id="domains" class="col-sm-10">
<?php
						}
?>
						<div id="domain" class="d-inline">
							<input type="text" class="col-10 col-md-5 form-control d-inline mb-1" name="domain[]" value="<?php echo str_replace('"', '', trim($line[1])); ?>">
							<button id="deleteSourceDomain" class="btn btn-sm btn-secondary pt-0 text-center align-middle mb-1 mb-md-2 mr-md-3">
								<strong>-</strong>
							</button>
						</div>
<?php
						$isDomain++;

						if ($isDomain == $totalSourceDomains) {
?>
					</div>
					<div class="col-sm-12 pb-2">
						<button id="addSourceDomain" class="btn btn-sm btn-secondary pt-0 text-center float-right">
							<strong>+</strong>
						</button>
					</div>
				</div>
<?php
						}

					} elseif (trim($line[0]) == 'matchUrl') {
?>
				<div class="form-group row">
					<label for="matchUrl" class="col-sm-2 col-form-label text-right">Url de origem</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="matchUrl" id="matchUrl" value="<?php echo str_replace('"', '', trim($line[1])); ?>">
					</div>
				</div>
<?php
					} elseif (trim($line[0]) == 'destinationUrl') {
?>
				<div class="form-group row">
					<label for="destinationUrl" class="col-sm-2 col-form-label text-right">Url de destino</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" name="destinationUrl" id="destinationUrl" value="<?php echo str_replace('"', '', trim($line[1])); ?>">
					</div>
					<div class="col-sm-1 pt-1">
						<a class="font-weight-bold" href="<?php echo str_replace('"', '', trim($line[1])); ?>" target="_blank">testar</a>
					</div>
				</div>
<?php
					} elseif (trim($line[0]) == 'appendMatchUrlToDestinationUrl') {
?>
				<div class="form-group row">
					<legend for="appendMatchUrl" class="col-form-label col-sm-2 text-right">Adicionar <span class="font-italic">relative path</span></legend>
					<div class="col-sm-10">
						<select class="form-control" name="appendMatchUrl" id="appendMatchUrl">
							<option value="1"<?php echo ((str_replace('"', '', trim($line[1])) == 'true') ? ' selected' : ''); ?>>Activo</option>
							<option value="0"<?php echo ((str_replace('"', '', trim($line[1])) == 'false') ? ' selected' : ''); ?>>Inactivo</option>
						</select>
					</div>
				</div>
<?php
					} elseif (trim($line[0]) == 'appendQueryStringToDestinationUrl') {
?>
				<div class="form-group row">
					<legend for="appendQueryString" class="col-form-label col-sm-2 text-right">Adicionar <span class="font-italic">query string</span></legend>
					<div class="col-sm-10">
						<select class="form-control" name="appendQueryString" id="appendQueryString">
							<option value="1"<?php echo ((str_replace('"', '', trim($line[1])) == 'true') ? ' selected' : ''); ?>>Activo</option>
							<option value="0"<?php echo ((str_replace('"', '', trim($line[1])) == 'false') ? ' selected' : ''); ?>>Inactivo</option>
						</select>
					</div>
				</div>
<?php
					} elseif (trim($line[0]) == 'forceHttps') {
?>
				<div class="form-group row">
					<legend for="forceHttps" class="col-form-label col-sm-2 text-right">Forçar HTTPS</legend>
					<div class="col-sm-10">
						<select class="form-control" name="forceHttps" id="forceHttps">
							<option value="1"<?php echo ((str_replace('"', '', trim($line[1])) == 'true') ? ' selected' : ''); ?>>Activo</option>
							<option value="0"<?php echo ((str_replace('"', '', trim($line[1])) == 'false') ? ' selected' : ''); ?>>Inactivo</option>
						</select>
					</div>
				</div>
<?php
					} elseif (trim($line[0]) == 'logRule') {
?>
				<div class="form-group row">
					<label for="log" class="col-sm-2 col-form-label text-right">Log</label>
					<div class="col-sm-10">
						<select class="form-control btn-light disabled" name="log" id="log" disabled>
							<option value="1"<?php echo ((str_replace('"', '', trim($line[1])) == 'true') ? ' selected' : ''); ?>>Activo</option>
							<option value="0"<?php echo ((str_replace('"', '', trim($line[1])) == 'false') ? ' selected' : ''); ?>>Inactivo</option>
						</select>
					</div>
				</div>
<?php
					} elseif (trim($line[0]) == 'debug') {
?>
				<div class="form-group row">
					<label for="debug" class="col-sm-2 col-form-label text-right">Debug</label>
					<div class="col-sm-10">
						<select class="form-control btn-light disabled" name="debug" id="debug" disabled>
							<option value="1"<?php echo ((str_replace('"', '', trim($line[1])) == 'true') ? ' selected' : ''); ?>>Activo</option>
							<option value="0"<?php echo ((str_replace('"', '', trim($line[1])) == 'false') ? ' selected' : ''); ?>>Inactivo</option>
						</select>
					</div>
				</div>
<?php
					}

				}	// preg_match "ruleId" i.e: [blablabla]

			}		// foreach

		}			// preg_match defaultRule
?>
				<div class="form-group pt-1">
					<input class="btn btn-primary float-right" type="submit" value="Gravar">
				</div>
			</form>
		</div><!-- /container -->
		<br />
		<br />
<?php

	}

} else {

	$style = "
		.searchbar {
			position: relative;
			min-width: 39px;
			max-width: 300px;
			width: 0%;
			float: right;
			overflow: hidden;
			-webkit-transition: width 0.3s;
			-moz-transition: width 0.3s;
			-ms-transition: width 0.3s;
			-o-transition: width 0.3s;
			transition: width 0.3s
		}
		.searchbar-input {
			right: 1rem;
		}
		.searchbar-input:focus {
			box-shadow: none;
		}
		.searchbar-icon,
		.searchbar-submit {
			display: block;
			position: absolute;
			top: 0;
			font-family: verdana;
			font-size: 22px;
			right: 0;
			padding: 0;
			margin: 0;
			border: 0;
			outline: 0;
			line-height: 50px;
			text-align: center;
			cursor: pointer;
			color: #fff;
			background: #fff;
			border-left: 1px solid white
		}
		.searchbar-open {
			width: 100%
		}
	";
	$script = "

		$(document).ready(function() {
			var submitIcon = $('.searchbar-icon');
			var inputBox = $('.searchbar-input');
			var searchbar = $('.searchbar');
			var isOpen = false;
			submitIcon.click(function() {
				if (isOpen == false) {
					searchbar.addClass('searchbar-open');
					inputBox.focus();
					isOpen = true;
				} else {
					var inputVal = $('.searchbar-input').val();
					inputVal = $.trim(inputVal).length;
					if ( inputVal > 2) {
						searchbar.addClass('searchbar-open');
						inputBox.focus();
						isOpen = true;
					} else {
						searchbar.removeClass('searchbar-open');
						inputBox.focusout();
						inputBox.val('');
						isOpen = false;
					}
				}
			});
			submitIcon.mouseup(function() {
				return false;
			});
			searchbar.mouseup(function() {
				return false;
			});
			$(document).mouseup(function() {
				if (isOpen == true) {
					$('.searchbar-icon').css('display','block');
					submitIcon.click();
				}
			});

			$('#search-input').keyup(function() {
				search();
			});

			function search() {
				var input, filter, table, tr, td, i;
				input = document.getElementById(\"search-input\");
				filter = input.value.toLowerCase();
				table = document.getElementById(\"searchable-main\");
				tr = table.getElementsByClassName(\"card-deck\");
				for (i = 0; i < tr.length; i++) {
					td = tr[i].getElementsByClassName(\"card\");
					for (j = 0; j < td.length; j++) {
						if (filter.length > 2) {
							if (td[j].innerHTML.toLowerCase().indexOf(filter) > -1) {
								tr[i].style.display = \"\";
								td[j].style.backgroundColor=\"black\";
							} else {
								tr[i].style.display = \"none\";
								td[j].style.backgroundColor=\"\";
							}
						} else {
							tr[i].style.display = \"\";
							td[j].style.backgroundColor=\"\";
						}
					}
				}
			}
		});

	";

	$cardsPerRow = 3;
	$i = 0;
	$rulesArray = parse_ini_file($rulesFile, true);

	if (isset($style) && !empty($style)) {
?>
		<script type="text/javascript">
			//<![CDATA[
				document.getElementById('css-<?php echo $uniqid; ?>').innerHTML = <?php echo json_encode($style); ?>;
			//]]>
		</script>
<?php
	}
	if (isset($script) && !empty($script)) {
?>
		<script type="text/javascript">
			//<![CDATA[
				document.getElementById('jvs-<?php echo $uniqid; ?>').innerHTML = <?php echo json_encode($script); ?>;
			//]]>
		</script>
<?php
	}
?>
		<div id="searchable-main" class="container">
<?php
	foreach($rulesArray as $ruleId => $ruleValues) {
		if (!preg_match('/^' . $defaultRule . '$/', $ruleId)) {
			if ($i % $cardsPerRow == 0) {
?>
			<div class="card-deck mb-<?php echo $cardsPerRow; ?> text-center">
<?php
			}
?>
				<div id="<?php echo $ruleId; ?>" class="card mb-4 box-shadow border-secondary">
					<div class="card-header border-secondary">
						<h6 class="my-0 font-weight-bold">
							<a href="?edit=<?php echo $ruleId; ?>"><?php echo $ruleId; ?></a>
						</h6>
					</div><!-- /card-header -->
					<div class="card-body d-flex flex-column">
						<ul class="list-unstyled">
							<small class="text-left">
<?php
			$j = 1;
			foreach($ruleValues as $ruleNodeName => $ruleNodeValue) {
				if (is_array($ruleNodeValue)) {
					echo "								<li class=\"pl-1 pr-1 overflow-auto" . (($j % 2 != 0) ? ' bg-light' : '' ) . "\">\n";
					echo "									<strong>" . $ruleNodeName . "</strong>\n";
					echo "								</li>\n";
					echo "								<ul" . (($j % 2 != 0) ? ' class="bg-light"' : '' ) . ">\n";
					foreach($ruleNodeValue as $ruleSubNodeName => $ruleSubNodeValue) {
						echo "									<li>" . $ruleSubNodeValue . "</li>\n";
					}
					echo "								</ul>\n";
				} else {
					echo "								<li class=\"pl-1 pr-1 overflow-auto" . (($j % 2 != 0) ? ' bg-light' : '' ) . "\">\n";
					echo "									<strong>" . $ruleNodeName . "</strong>\n";
					echo "									<span class=\"float-right\">" . $ruleNodeValue . "</span>\n";
					echo "								</li>\n";
				}
				$j++;
			}
			unset($j);
?>
							</small>
						</ul><!-- /list-unstyled -->
						<div class="mt-auto">
							<a class="btn btn-lg btn-block btn-light" href="?edit=<?php echo $ruleId; ?>">Editar</a>
						</div><!-- /mt-auto -->
					</div><!-- /card-body -->
				</div><!-- /card -->
<?php
			if (($i + 1) % $cardsPerRow == 0) {
?>

			</div><!-- /card-deck -->
<?php
			}
		}
		$i++;
	}
?>
		</div><!-- /container -->
		<div class="pb-3 container">
			<p>
				Existem <strong><?php echo $i; ?></strong> regras configuradas.
				<br />
				Um total de <strong><?php echo filesizeHumanReadable(filesize($rulesFile)); ?></strong> em configurações.
			</p>
		</div><!-- /container -->
<?php
}
?>
	</body>
</html>
<?php
function filesizeHumanReadable($bytes, $decimals = 2) {
	$sz = 'BKMGTP';
	$factor = floor((strlen($bytes) - 1) / 3);
	return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor] . "b";
}
?>