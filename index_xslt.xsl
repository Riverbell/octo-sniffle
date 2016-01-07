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

		<xsl:if test="@favorites = 'ok'">
			<form action="favorite_event.php" method="post">
				<input type="hidden" value="{$event_id}" name="event_id"/>
				<input type="submit" value="Lägg i favoriter"/>
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