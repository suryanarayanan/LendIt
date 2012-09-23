<html>
<head>
	<title> Lendit </title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script type="text/javascript" src="//www.google.com/jsapi"></script>
	<style>
		.viewerCanvas{
			width: 24%;
			height: 250px;
			display: none;
			float: left;
			padding-left: 5px;
		}
		.separator{
			float: left;
			width: 100%;
		}
	</style>
</head>
	
	<body>
	<h1>LendIt</h1> 
		Search Book: 
		<input type="text" id="booksearch" maxlength="200" >
		<div id="viewerStatus"
         	style="padding: 5px; background-color: #eee; display: block"></div>
        <div id="previewContainer">
        </div>
	</body>


	<script type="text/javascript">
		$(document).ready(function(){
			
			var parent;
			for(var i = 0; i < 20; i++){
				if(i % 4 == 0){
					parent = $('<div>', {'class': 'separator'}).appendTo('#previewContainer');
				}
				$('<div>', {
					'class': 'viewerCanvas', 
					'id': i + 'viewerCanvas'
				}).appendTo(parent);
				
			}
			//Allow you to delay
			//http://stackoverflow.com/questions/4347993/jquery-delay-between-keyup-functions
			var isLoading = false;
			var isDirty = false;
			function reloadSearch(){
				if(!isLoading){
			      var q = $('#booksearch').val();
			       if (q.length >= 5) {
			          isLoading = true;
			           // ajax fetch the data
			           $('#viewerStatus').html("fetching...");
			       		searchBook(q);
			           // enforce the delay
			           setTimeout(function(){
			             isLoading=false;
			             if(isDirty){
			               isDirty = false;
			               reloadSearch();
			             }
			           }, 2000);
			       } else {
			       	hideCanvas();
			       }
			     }
			}
			$('#booksearch').keyup(function(){	
				isDirty = true;
				reloadSearch();	
				$('#viewerStatus').html("Done fetching...");	
			});

			function searchBook(bookname){
				hideCanvas();
				$.ajax({
					url: 'https://www.googleapis.com/books/v1/volumes?q=' + bookname,
					type: 'get', 
					data: 'json', 
					success: function(data){
						loadResults(data);
					}, 
				});
			}

			function loadResults(results){
				var res = results.items || [];
				var loaded = 0;
				for(var i = 0; i < res.length; i++){
					var entry = res[i];
					var id = entry.id;
					var embeddable = entry.accessInfo.embeddable;
					if(embeddable){
						loadBook(id, loaded++);
					}
				}
				if(loaded == 0)
					$('#viewerStatus').html("No books available...");


			}

			function loadBook(id, loaded){
				var showbookcallback = function(){showBook(id, loaded);};
				google.load("books", "0", {"callback": showbookcallback});
			}

			function showBook(id, loaded){
				var canvas = document.getElementById(loaded + 'viewerCanvas');
				viewer = new google.books.DefaultViewer(canvas);
				viewer.load(id);
				showCanvas(canvas);
			}

			function showCanvas(showing){
				//var canvasDiv = $('#viewerCanvas').css('display', showing ? 'block' : 'none');
				$(showing).show();
			}

			function hideCanvas(){
				$('.separator').children().each(function(){
					$(this).hide();
				});
			}

			function clearStatus(){
				$('#viewerStatus').empty();
			}
		});
	</script>
</html>
