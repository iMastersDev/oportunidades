<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns:p="urn:Ophportunidades/Presentation"
                exclude-result-prefixes="p">

    <xsl:import href="form.xsl" />

    <xsl:output indent="yes"
                omit-xml-declaration="yes"
                encoding="UTF-8"
                media-type=""
                method="html" />

    <xsl:template match="/">
        <xsl:text disable-output-escaping='yes'>&lt;!DOCTYPE html></xsl:text>
        <html>
            <head>
                <title>oPHPortunidades - <xsl:value-of select=".//p:presentation/p:title" /></title>
                <xsl:if test=".//p:presentation/p:description">
                    <xsl:element name="meta">
                        <xsl:attribute name="description">
                            <xsl:value-of select=".//p:presentation/p:description" />
                        </xsl:attribute>
                    </xsl:element>
                </xsl:if>
                <link rel="stylesheet" type="text/css" href="/theme/default/css/default.css" />
            </head>
            <body>
                <header>
                    <div class="main-width clear">
		                <h1><a href="/" title="oPHPortunidades">oPHPortunidades</a></h1>
	                  <form id="search" action="search.php" method="get">
	                      <input type="text" name="q" placeholder="Procurar Oportunidade" />
	                      <button type="submit">Pesquisar</button>
	                  </form>
		            </div>
                </header>

                <article>
	                <div class="main-width">
	                    <h2><xsl:value-of select=".//p:presentation/p:title" /></h2>
		                <xsl:choose>
		                    <xsl:when test=".//p:presentation/p:form">
		                        <xsl:apply-templates select=".//p:presentation/p:form" />
		                    </xsl:when>
		                    <xsl:when test=".//p:presentation/p:list">
		                        <xsl:apply-templates select=".//p:presentation/p:list" />
		                    </xsl:when>
		                </xsl:choose>
		            </div>
                </article>

                <footer>
                    <div class="main-width">
                       <ul class="clear">
                           <li class="imasters">
                               <dl>
                                   <dt>Realiação:</dt>
                                   <dd><a href="http://imasters.com.br">iMasters</a></dd>
                               </dl>
                           </li>
                           <li class="host">
                                  <dl>
                                      <dt>Hospedagem:</dt>
                                      <dd><a href="https://pagodabox.com/">pagoda box</a></dd>
                                  </dl>
                              </li>
                           <li class="github">
                               <dl>
                                      <dt>Fork us on:</dt>
                                      <dd><a href="https://github.com/iMastersDev/oportunidades">GitHub</a></dd>
                                  </dl>
                           </li>
                       </ul>
		            </div>
                </footer>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>