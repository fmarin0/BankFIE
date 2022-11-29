<nav class="menu" tabindex="0">
	<div class="smartphone-menu-trigger"></div>
  <header class="avatar">
		<img src="http://bankfie.com/public/img/<?php echo $user['img_client']; ?>">
    <h2><?php echo $user['name']; ?></h2>
  </header>
	<ul>
    <a href="http://bankfie.com/ejecutivo">                <li tabindex="0" class="icon-dashboard">               <span>Inicio       </span></li></a>
    <a href="http://bankfie.com/ejecutivo/registro">       <li tabindex="0" class="icon-fa-duotone fa-user-plus"> <span>Registro     </span></li></a>
    <a href="http://bankfie.com/ejecutivo/prestamos">      <li tabindex="0" class="icon-customers">               <span>Prestamos    </span></li></a>
    <a href="http://bankfie.com/ejecutivo/transacciones">  <li tabindex="0" class="icon-users">                   <span>Transacciones</span></li></a>
    <a href="http://bankfie.com/includes/cerrarSesion.php"><li tabindex="0" class="icon-settings">                <span>Cerrar sesion</span></li></a>
  </ul>
</nav>