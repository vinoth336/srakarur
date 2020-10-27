<?php
	global $db;
	if($_SESSION['type'] == 'admin')
		$sql = "select * from menu_bar order by `orderby` ;";
	else{
		$sql = "select a.* from menu_bar as a 
			inner join role_level_permission as b on b.menu_id = a.id and ( rolename = '{$_SESSION['type']}' or rolename = 'COMMON' )
			 ;";
	}
	$ex = $db->query($sql);
	$menupages = array();
	$pages = array();	
	while($rs = $db->FetchByAssoc($ex)){

		if($rs['parent'] != 99 && $rs['parent'] != 98 ){
			if($rs['parent'] == '' && $menu[$rs['id']] == ''){
				$menu[$rs['id']] = $rs;
			}
			else{
				$menu[$rs['parent']]['submenu'][] = $rs;
				$menupages[$rs['parent']][] = $rs['action'];
			}
		}
		$pages[] = $rs['action'];
	}
?>
      <div class="sidebar-wrapper">

        <ul class="nav navbar-nav nav-mobile-menu">
		<li class="nav-item dropdown">
                <a class="nav-link" href="http://srakarur.com"  target="_blank">
                  <p class="d-lg-none d-md-block">
                    	View Site 
                  </p>
                </a>
              </li>
		<li class="nav-item dropdown">
                <a class="nav-link" href="#pablo" id="navbarDropdownProfile2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">person</i>
                  <p class="d-lg-none d-md-block">
                    Account  <b class="caret"></b>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile2">
                  <a class="dropdown-item" href="Profile.php">Profile</a>
                  <a class="dropdown-item" href="Logout.php">Log out</a>
                  <div class="dropdown-divider"></div>
                </div>
              </li>


	<?php
		foreach($menu as $id => $option){
		?>
		  <li class="nav-item <?php echo $option['action'] == $page_name || in_array($page_name,$menupages[$option['id']]) ? 'active' : '' ?>">
			<?php
				if(isset($option['submenu'])){
				$menuname = str_replace(" ",'',$option['menu_name']);
			?>
				<a class="nav-link collapsed " data-toggle="collapse" href="#<?php echo $menuname;?>2" aria-expanded="<?php echo in_array($page_name,$menupages[$option['id']]) ? 'true' : 'false'; ?>">	
			<?php
				}else{
			?>		
		    			<a class="nav-link" href="<?php echo $option['action'] == '' ? '' : $option['action']?>" >
			<?php
				}
			?>
		      <i class="material-icons"><?php echo $option['icon']?></i>
		      <p><?php echo $option['menu_name'] ?>
		      <?php
				if(isset($option['submenu'])){
				?>
					<b class="caret"></b>
				<?php	
				}
		      ?>				
		     </p>
		    </a>
		    <?php
				if(isset($option['submenu'])){
				?>
				 <div class="collapse <?php echo in_array($page_name,$menupages[$option['id']]) ? 'show' : '' ?>" id="<?php echo $menuname;?>2" style="">
				      <ul class="nav">
					<?php
					foreach($option['submenu'] as $subid => $menuoption){
					?>
						<li class="nav-item  <?php echo $menuoption['action'] == $page_name ? 'active' : '' ?>">
						  <a class="nav-link" href="<?php echo $menuoption['action']?>">
						    <span class="sidebar-mini"> <?php echo substr($menuoption,0,1); ?></span>
						    <span class="sidebar-normal"><?php echo $menuoption['menu_name'] ?></span>
						  </a>
						</li>
					<?php
					}
					?>
				     </ul>
				</div>
				<?php
				}
		    ?>			
		  </li>
		<?php
		}
	?>

        </ul>

        <ul class="nav hidden-xs">
	<?php
		foreach($menu as $id => $option){
		?>
		  <li class="nav-item <?php echo $option['action'] == $page_name || in_array($page_name,$menupages[$option['id']]) ? 'active' : '' ?>">
			<?php
				if(isset($option['submenu'])){
				$menuname = str_replace(" ",'',$option['menu_name']);
			?>
				<a class="nav-link collapsed " data-toggle="collapse" href="#<?php echo $menuname;?>" aria-expanded="<?php echo in_array($page_name,$menupages[$option['id']]) ? 'true' : 'false'; ?>">	
			<?php
				}else{
			?>		
		    			<a class="nav-link" href="<?php echo $option['action'] == '' ? '' : $option['action']?>" >
			<?php
				}
			?>
		      <i class="material-icons"><?php echo $option['icon']?></i>
		      <p><?php echo $option['menu_name'] ?>
		      <?php
				if(isset($option['submenu'])){
				?>
					<b class="caret"></b>
				<?php	
				}
		      ?>				
		     </p>
		    </a>
		    <?php
				if(isset($option['submenu'])){
				?>
				 <div class="collapse <?php echo in_array($page_name,$menupages[$option['id']]) ? 'show' : '' ?>" id="<?php echo $menuname;?>" style="">
				      <ul class="nav">
					<?php
					foreach($option['submenu'] as $subid => $menuoption){
					?>
						<li class="nav-item  <?php echo $menuoption['action'] == $page_name ? 'active' : '' ?>">
						  <a class="nav-link" href="<?php echo $menuoption['action']?>">
						    <span class="sidebar-mini"> <?php echo substr($menuoption,0,1); ?></span>
						    <span class="sidebar-normal"><?php echo $menuoption['menu_name'] ?></span>
						  </a>
						</li>
					<?php
					}
					?>
				     </ul>
				</div>
				<?php
				}
		    ?>			
		  </li>
		<?php
		}
	?>

        </ul>
      </div> 
<?php

	if(!in_array($page_name,$pages)){
		echo "<h2>INVALID ACCESS</h2>";
		exit;	
	}

?>
