<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
                xmlns:rss="http://purl.org/rss/1.0/"
                xmlns:dc="http://purl.org/dc/elements/1.1/"
                xmlns:syn="http://purl.org/rss/1.0/modules/syndication/"
                xmlns="http://www.w3.org/1999/xhtml"
                version="1.0">
<xsl:output indent="yes"/> 

<xsl:template match="bookingSystem">
	<html>
		<head>
			<title><xsl:value-of select="title"/></title>
			<link rel="stylesheet" type="text/css" href="/~emmabac/DM2517/project/style.css"/>

			<script language = "javascript" type = "text/javascript">
            <xsl:text disable-output-escaping="yes">
            function ajaxFunction(id, ajaxDisplay, act){
               var ajaxRequest; 
               
               try {
                  // Opera 8.0+, Firefox, Safari
                  ajaxRequest = new XMLHttpRequest();
               }catch (e) {
                  // Internet Explorer Browsers
                  try {
                     ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
                  }catch (e) {
                     try{
                        ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
                     }catch (e){
                        // Something went wrong
                        alert("Your browser broke!");
                        return false;
                     }
                  }
               }
               
               // Create a function that will receive data 
               // sent from the server and will update
               // div section in the same page.
					
               ajaxRequest.onreadystatechange = function(){
                  if(ajaxRequest.readyState == 4){
                     //var ajaxDisplay = document.getElementById('fav_sub_1');
                     ajaxDisplay.innerHTML = ajaxRequest.responseText;
                  }
               }
               
               // Now get the value from user and pass it to
               // server script.
					
               //var id = document.getElementById('fav_event_1').value;

               //querystring is what is written in the url
               //since the ajax-example.php is using get, we can
               //write our desired input in the url
               var queryString = "?event_id=" + id + "&amp;act=" + act ;
               
               console.log(queryString);

               ajaxRequest.open("GET", "favorite_event.php" + queryString, true);
               ajaxRequest.send(null); 
            }
         //-->
     </xsl:text>
      </script>
		</head>
		<body>
			<h1><xsl:value-of select="title"/></h1>
			<xsl:apply-templates/>

		</body>
	</html>
</xsl:template>

<xsl:template match="menu">
	<div class="menu">
		<h2>Meny</h2>
		<ul>
			<xsl:apply-templates/>
		</ul>
	</div>
</xsl:template>

<xsl:template match="menuItem">
	<li>
		<a href="{@link}"><xsl:apply-templates/></a>
	</li>
</xsl:template>

<xsl:template match="event">
	<xsl:variable name="event_id" select="@id"/>
	<div class="container">
		<h2>
			<xsl:value-of select="name"/>
		</h2>
		<ul>
			<xsl:apply-templates/>
		</ul>
		<!-- only show edit button if the logged in user is the creator -->
		<xsl:if test="@edit = 'ok'">
			<form action="update_event.php" method="post">
				<input type="hidden" value="{$event_id}" name="event_id"/>
				<input type="submit" value="Ändra"/>
			</form>
		</xsl:if>

		<!-- only show book button if the logged in user is a user -->
		<xsl:if test="@book = 'ok'">
			<form action="book_event.php" method="post">
				<input type="hidden" value="{$event_id}" name="event_id"/>
				<input type="submit" value="Boka"/>
			</form>
		</xsl:if>

		
		<xsl:if test="@favorites = 'ok_fav'">
			<form id="fav_{$event_id}">
				<input type="hidden" value="{$event_id}" name="event_id" id="fav_event_{$event_id}"/>
				<div id="fav_sub_{$event_id}">
					<input type="button" value="Ta bort från favoriter" onclick = "ajaxFunction({$event_id}, fav_sub_{$event_id}, 'del')"/>
				</div>
			</form>
		</xsl:if>
		<xsl:if test="@favorites = 'ok_nofav'">
			<form id="fav_{$event_id}">
				<input type="hidden" value="{$event_id}" name="event_id" id="fav_event_{$event_id}"/>
				<div id="fav_sub_{$event_id}">
					<input type="button" value="Lägg i favoriter" onclick = "ajaxFunction({$event_id}, fav_sub_{$event_id}, 'add')"/>
				</div>
			</form>
		</xsl:if>
	</div>
</xsl:template>

<xsl:template match="title"/>
<xsl:template match="event/name"/>
<xsl:template match="event/total_tickets"/>

<xsl:template match="event/available_tickets">
	<li>
		Lediga platser: <xsl:apply-templates/> av <xsl:value-of select="../total_tickets"/>
	</li>
</xsl:template>

<xsl:template match="event/venue">
	<li>
		Arena: <xsl:apply-templates/>
	</li>
</xsl:template>

<xsl:template match="event/creator">
	<li>
		Arrangör: <xsl:apply-templates/>
	</li>
</xsl:template>

<xsl:template match="event/category">
	<li>
		Kategori: <xsl:apply-templates/>
	</li>
</xsl:template>

<xsl:template match="event/startdate">
	<li>
		Datum: <xsl:apply-templates/> kl <xsl:value-of select="../starttime"/>
	</li>
</xsl:template>

<xsl:template match="event/starttime"/>

</xsl:stylesheet>