<?php
require 'includes/phpHelper.php';
require findRelativePath('includes/supernova.config.php');
?>
<?php require_once findRelativePath('includes/mainContentFrameHead.php'); ?>

</head>
<body>
<form id="mainForm" name="form1" method="post" action="<?php echo findRelativePath('handlers/update.php') ?>">
<!-- == FORM CONTENT BEGIN ============================================================== -->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><span id="formHeader">Welcome to the Supernova Registration System</span></td>
  </tr>
</table>

<!-- == FORM CONTENT END ================================================================ -->
</form>
</body>