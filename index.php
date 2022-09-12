
<!DOCTYPE html>
<html lang="en">
	<head>
	  <meta charset="utf-8">
	  <title>PruebaDoonamis</title>
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <meta name="Asier García" content="">
	  <script src="resources/js/jquery-3.6.1.min.js"></script>
	  <style>
	  <!-- Just two styles, no need to stylesheet -->
	    ul {
			list-style-type: none;
		}
		.pagination li{
			display:inline-block;
		}
	  </style>
	</head>

	<body>
	  
		<div class="container">
			<h1>Publicaciones</h1>
			<ul class="list"></ul>
			<nav aria-label="Page navigation example">
				  <ul class="pagination">
					<li id="prev-page" class="page-item"><a class="page-link" href="#">Anterior</a></li>
					<li id="next-page" class="page-item"><a class="page-link" href="#">Siguiente</a></li>
				  </ul>
			</nav>
			<div class="pages"></div>
		</div>

		<script>
			$(document).ready(function() {
				$.ajax({
					url:'http://127.0.0.1:8000/api/publicaciones',
					type: 'GET',
					success: function(data){
						$('.list').empty();
						// add items to ul
							for( let i = 0; i < data.length; i++ ){
								$('.list').append('<li class = "list-group">' + data[i].title + '</li>');
							}
						
						// Pagination
							var numItems = data.length;
							var limit = 10;
							var totalPages = Math.round(numItems / limit);
							var current = 1;
							
							// just show 1st 10 items gt:selector
							$('.list-group:gt(' + (limit - 1) +')').hide();
							$('.pages').append(limit + "/" + numItems);
							
							// next functionality
							$('#next-page').on('click', function(){
								if(current === totalPages){
									return false;
								}else{
									let grandTotal = limit * current;
									current++;
									
									// hide the group of 10 and show the next 10
									$('.list-group').hide();
									
									for( let i = grandTotal - limit ; i < grandTotal ; i++ ){
										$('.list-group:eq(' + i + ')').show();
									}
									
									// update nº pages
									$('.pages').empty();
									$('.pages').append((grandTotal + limit) + "/" + numItems);
									
								}
							});
							
							// prev functionality
							$('#prev-page').on('click', function(){
								if(current === 1){
									return false;	
								}else{
									let grandTotal = limit * current;
									current--;
									
									$('.list-group').hide();

									for( let i = grandTotal - limit ; i < grandTotal ; i++ ){
										$('.list-group:eq(' + i + ')').show();
									}
									
									$('.pages').empty();
									$('.pages').append((grandTotal - limit) + "/" + numItems);
									
								}
							});

					}, 
					error: function(){
						$('.list').empty();
						$('.list').append('No se pudo cargar el listado');
					}
				});
			});
		</script>
	</body>
</html>
