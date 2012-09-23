<html>
<head>
	<title> Lendit </title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script type="text/javascript" src="//www.google.com/jsapi"></script>
</head>
	
	<body>
	<h1>LendIt</h1> 
		Search Book: 
		<input type="text" id="booksearch" maxlength="200" >
		<div id="viewerStatus"
         	style="padding: 5px; background-color: #eee; display: none"></div>
    	<div id="viewerCanvas"
         	style="width: 500px; height: 400px; display: none"></div>
	</body>


	<script type="text/javascript">
		$(document).ready(function(){
			$('#booksearch').keyup(function(){
				var bookname = $(this).val();		
				if(bookname.length < 5){
					showCanvas(false);
					return;
				}
				searchBook(bookname);				
			});

			function searchBook(bookname){
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
				for(var i = 0; i < res.length; i++){
					var entry = res[i];
					var id = entry.id;
					var embeddable = entry.accessInfo.embeddable;
					if(embeddable){
						loadBook(id);
						return;
					}
				}
				showStatus("Could not load any books");

			}

			function loadBook(id){
				var showbookcallback = function(){showBook(id);};
				google.load("books", "0", {"callback": showbookcallback});
			}

			function showBook(id){
				var canvas = document.getElementById('viewerCanvas');
				viewer = new google.books.DefaultViewer(canvas);
				viewer.load(id);
				showCanvas(true);
				showStatus('');
			}

			function showCanvas(showing){
				var canvasDiv = $('#viewerCanvas');
				canvasDiv.css('display', showing ? 'block' : 'none');
			}

			function showStatus(string){
				var statusDiv = $('#viewerStatus');
				var showing = string != null && string.length > 0;
				if(statusDiv.children().length > 0){
					statusDiv.empty();
				}
				$('<div>', {'text': string}).css('display', showing ? 'block' : 'none').appendTo(statusDiv);

			}
		});
	</script>
</html>
