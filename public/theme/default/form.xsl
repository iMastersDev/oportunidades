<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns:p="urn:Ophportunidades/Presentation"
                exclude-result-prefixes="p">

    <xsl:template match="p:field">
        <xsl:variable name="id"><xsl:value-of select="generate-id(.)" /></xsl:variable>
        
        <div class="field">
	        <xsl:if test="./@label and ./@type!='submit'">
	            <xsl:element name="label">
	                <xsl:attribute name="for"><xsl:value-of select="$id" /></xsl:attribute>
	                <xsl:value-of select="./@label" />
	            </xsl:element>
	        </xsl:if>
	
            <xsl:choose>
                <xsl:when test="./@label and ./@type='submit'">
                    <xsl:element name="button">
                        <xsl:attribute name="type"><xsl:value-of select="./@type" /></xsl:attribute>
                        <xsl:attribute name="name"><xsl:value-of select="./@name" /></xsl:attribute>
	                    <xsl:value-of select="@label" />
                    </xsl:element>
                </xsl:when>
                <xsl:when test="./@label">
			        <xsl:element name="input">
		                <xsl:attribute name="id"><xsl:value-of select="$id" /></xsl:attribute>
			            <xsl:attribute name="type"><xsl:value-of select="./@type" /></xsl:attribute>
			            <xsl:attribute name="name"><xsl:value-of select="./@name" /></xsl:attribute>
			        </xsl:element>
                </xsl:when>
            </xsl:choose>
            
	    </div>
    </xsl:template>

    <xsl:template match="p:form">
        <xsl:element name="form">
            <xsl:attribute name="action"><xsl:value-of select="./@action" /></xsl:attribute>

            <xsl:choose>
                <xsl:when test="./@method">
                    <xsl:attribute name="method"><xsl:value-of select="./@method" /></xsl:attribute>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:attribute name="method">post</xsl:attribute>
                </xsl:otherwise>
            </xsl:choose>

            <xsl:for-each select="./p:field">
                <xsl:apply-templates select="." />
            </xsl:for-each>
        </xsl:element>
    </xsl:template>
</xsl:stylesheet>