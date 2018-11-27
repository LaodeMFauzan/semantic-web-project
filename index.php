<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Neon Admin Panel" />
	<meta name="author" content="" />

	<link rel="icon" href="assets/images/favicon.ico">

	<title>Paduan Akademik</title>

	<link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
	<link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css">
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/neon-core.css">
	<link rel="stylesheet" href="assets/css/neon-theme.css">
	<link rel="stylesheet" href="assets/css/neon-forms.css">
	<link rel="stylesheet" href="assets/css/custom.css">

	<script src="assets/js/jquery-1.11.3.min.js"></script>

</head>
    
<body class="page-body boxed-layout" data-url="http://neon.dev">

<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
	
	<div class="sidebar-menu">

		<div class="sidebar-menu-inner">
			
			<header class="logo-env">

				<!-- logo -->
				<div class="logo">
					<a href="index.php">
						<img src="" width="120" height="56" alt="" />
					</a>
				</div>

				<!-- logo collapse icon -->
				<div class="sidebar-collapse">
					<a href="#" class="sidebar-collapse-icon"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
						<i class="entypo-menu"></i>
					</a>
				</div>

								
				<!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
				<div class="sidebar-mobile-menu visible-xs">
					<a href="#" class="with-animation"><!-- add class "with-animation" to support animation -->
						<i class="entypo-menu"></i>
					</a>
				</div>

			</header>
			
									
			<ul id="main-menu" class="main-menu">
				<!-- add class "multiple-expanded" to allow multiple submenus to open -->
				<!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->
				<li>
					<a href="index.php">
						<i class="entypo-window"></i>
						<span class="title">Home</span>
					</a>
				</li>
				<li>
					<a href="detail.php">
						<i class="entypo-doc-text"></i>
						<span class="title">Detail</span>
					</a>
				</li>
			</ul>
			
		</div>

	</div>

	<div class="main-content">
		
		<hr />
					
		<h2>List</h2>
		
		<br />
		
		<script type="text/javascript">
		jQuery( document ).ready( function( $ ) {
			var $table3 = jQuery("#table-3");
            
			var table3 = $table3.DataTable( {
				"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
			} );
			
			// Initalize Select Dropdown after DataTables is created
			$table3.closest( '.dataTables_wrapper' ).find( 'select' ).select2( {
				minimumResultsForSearch: -1
			});
			
			// Setup - add a text input to each footer cell
			$( '#table-3 tfoot th' ).each( function () {
				var title = $('#table-3 thead th').eq( $(this).index() ).text();
				$(this).html( '<input type="text" class="form-control" placeholder="Search ' + title + '" />' );
			} );
			
			// Apply the search
			table3.columns().every( function () {
				var that = this;
			
				$( 'input', this.footer() ).on( 'keyup change', function () {
					if ( that.search() !== this.value ) {
						that
							.search( this.value )
							.draw();
					}
				} );
			} );
		} );
		</script>
		
		<table class="table table-bordered datatable" id="table-3">
			<thead>
				<tr class="replace-inputs">
					<th>Mata Kuliah</th>
					<th>SKS</th>
					<th>Kode Matkul</th>
					<th>Prasyarat</th>
				</tr>
			</thead>
			<tbody>
				<?php
                include 'fuseki.php';
                $request = new Fuseki('http://localhost:3030', 'projek-ws');
            
                $sparql = "PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
					prefix owl: <http://www.w3.org/2002/07/owl#>
					prefix rdfs: <http://www.w3.org/2000/01/rdf-schema#>
					prefix mata-kuliah: <http://www.semanticweb.org/ontologies/2018/10/mata-kuliah.owl#> 

					SELECT DISTINCT ?matakuliah ?sks ?kodeMatkul ?prasyaratMK
					WHERE {
					  mata-kuliah:MataKuliah a owl:Class.
					  ?Mmatkul rdf:type mata-kuliah:MataKuliah.
					  ?Mmatkul rdfs:label ?matakuliah.
					  ?Mmatkul mata-kuliah:hasJumlahSKS ?Msks.
					  ?Msks rdfs:label ?sks.
					  ?Mmatkul mata-kuliah:hasKodeMatkul ?Mkodemk.
					  ?Mkodemk rdfs:label ?kodeMatkul.
					  ?Mmatkul mata-kuliah:hasPrasyarat ?Mprasyarat.
					  ?Mprasyarat rdfs:label ?prasyaratMK
					}
					LIMIT 25";
                    
                $request->setSparQl($sparql);
                $result = $request->sendRequest();
                
                foreach ($result as $loop) {
                    echo "<tr>";
                    echo "<td>" . $loop['matakuliah']['value'] . "</td>";
                    echo "<td>" . $loop['sks']['value'] . "</td>";
                    echo "<td>" . $loop['kodeMatkul']['value'] . "</td>";
                    echo "<td>" . $loop['prasyaratMK']['value'] . "</td>";
                    echo "</tr>";
                }
                ?>
			</tbody>
			<tfoot>
				<tr>
					<th>Mata Kuliah</th>
					<th>SKS</th>
					<th>Kode Matkul</th>
					<th>prasyaratMK</th>
				</tr>
			</tfoot>
		</table>
		
		<br />
		<!-- Footer -->
		<footer class="main">
			&copy; 2018 <strong>projek-ws</strong> by tim-kuda-hitam
		</footer>
	</div>
	
</div>


	<!-- Imported styles on this page -->
	<link rel="stylesheet" href="assets/js/datatables/datatables.css">
	<link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css">
	<link rel="stylesheet" href="assets/js/select2/select2.css">

	<!-- Bottom scripts (common) -->
	<script src="assets/js/gsap/TweenMax.min.js"></script>
	<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/joinable.js"></script>
	<script src="assets/js/resizeable.js"></script>
	<script src="assets/js/neon-api.js"></script>


	<!-- Imported scripts on this page -->
	<script src="assets/js/datatables/datatables.js"></script>
	<script src="assets/js/select2/select2.min.js"></script>
	<script src="assets/js/neon-chat.js"></script>


	<!-- JavaScripts initializations and stuff -->
	<script src="assets/js/neon-custom.js"></script>


	<!-- Demo Settings -->
	<script src="assets/js/neon-demo.js"></script>

</body>
</html>