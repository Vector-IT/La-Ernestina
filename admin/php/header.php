<?php if (!isset($_REQUEST["header"]) || $_REQUEST["header"] == 1) {?>
	<div class="jumbotron rounded-0">
		<div class="container-fluid" style="min-height:50px;">
			<div>
				<?php if ($config->logo != '') { ?>
					<img class="logo" alt="Logo" src="<?php echo $config->logo?>" />
				<?php }?>
				<?php if ($config->showTitulo) { ?>
				<span class="titulo">
					<?php echo $config->titulo?>
				</span>
				<?php } ?>
			</div>
		</div>
		<?php if (isset($_SESSION['is_logged_in_'. $nombSistema])) { ?>
		<div class="absolute top5 right5 ucase">
			<i class="fa fa-user"></i>
			<small>
			<?php
				echo $_SESSION["NombPers"];
			?>
			</small>
			<button class="btn btn-outline-dark btn-sm" onclick="location.href='changePassword.php?returnUrl=<?php echo urlencode($_SERVER['REQUEST_URI'])?>';" data-toggle="tooltip" data-placement="bottom" title="<?php echo gral_changepwd?>"><i class="fas fa-key fa-fw"></i></button>
			<button class="btn btn-outline-dark btn-sm" onclick="location.href='logout.php';" data-toggle="tooltip" data-placement="bottom" title="<?php echo gral_signout?>"><i class="fa fa-sign-out-alt fa-fw"></i></button>
		</div>
		<?php }?>
	</div>
<?php } ?>