<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">
  <div class="box_title">
    <h1 class="title_01">How to force routes to always use HTTPS</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="how-to-force-routes-to-always-use-https">
      <span id="index-0"></span><h1>How to force routes to always use HTTPS<a class="headerlink" href="#how-to-force-routes-to-always-use-https" title="Permalink to this headline">¶</a></h1>
      <p>Sometimes, you want to secure some routes and be sure that they are always
	accessed via the HTTPS protocol. The Routing component allows you to enforce
	the HTTP scheme via the <tt class="docutils literal"><span class="pre">_scheme</span></tt> requirement:</p>
      <div class="configuration-block jsactive">
	<ul class="simple" style="height: 148px; ">
	  <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">secure</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">pattern</span><span class="p-Indicator">:</span>  <span class="l-Scalar-Plain">/secure</span>
    <span class="l-Scalar-Plain">defaults</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">_controller</span><span class="p-Indicator">:</span> <span class="nv">AcmeDemoBundle</span><span class="p-Indicator">:</span><span class="nv">Main</span><span class="p-Indicator">:</span><span class="nv">secure</span> <span class="p-Indicator">}</span>
    <span class="l-Scalar-Plain">requirements</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">_scheme</span><span class="p-Indicator">:</span>  <span class="l-Scalar-Plain">https</span>
	      </pre></div>
	    </div>
	  </li>
	  <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="cp">&lt;?xml version="1.0" encoding="UTF-8" ?&gt;</span>

<span class="nt">&lt;routes</span> <span class="na">xmlns=</span><span class="s">"http://symfony.com/schema/routing"</span>
    <span class="na">xmlns:xsi=</span><span class="s">"http://www.w3.org/2001/XMLSchema-instance"</span>
    <span class="na">xsi:schemaLocation=</span><span class="s">"http://symfony.com/schema/routing http://symfony.com/schema/routing/routing-1.0.xsd"</span><span class="nt">&gt;</span>

    <span class="nt">&lt;route</span> <span class="na">id=</span><span class="s">"secure"</span> <span class="na">pattern=</span><span class="s">"/secure"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;default</span> <span class="na">key=</span><span class="s">"_controller"</span><span class="nt">&gt;</span>AcmeDemoBundle:Main:secure<span class="nt">&lt;/default&gt;</span>
        <span class="nt">&lt;requirement</span> <span class="na">key=</span><span class="s">"_scheme"</span><span class="nt">&gt;</span>https<span class="nt">&lt;/requirement&gt;</span>
    <span class="nt">&lt;/route&gt;</span>
<span class="nt">&lt;/routes&gt;</span>
	      </pre></div>
	    </div>
	  </li>
	  <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\Routing\RouteCollection</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Routing\Route</span><span class="p">;</span>

<span class="nv">$collection</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">RouteCollection</span><span class="p">();</span>
<span class="nv">$collection</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'secure'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Route</span><span class="p">(</span><span class="s1">'/secure'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'_controller'</span> <span class="o">=&gt;</span> <span class="s1">'AcmeDemoBundle:Main:secure'</span><span class="p">,</span>
<span class="p">),</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'_scheme'</span> <span class="o">=&gt;</span> <span class="s1">'https'</span><span class="p">,</span>
<span class="p">)));</span>

<span class="k">return</span> <span class="nv">$collection</span><span class="p">;</span>
	      </pre></div>
	    </div>
	  </li>
	</ul>
      </div>
      <p>The above configuration forces the <tt class="docutils literal"><span class="pre">secure</span></tt> route to always use HTTPS.</p>
      <p>When generating the <tt class="docutils literal"><span class="pre">secure</span></tt> URL, and if the current scheme is HTTP, Symfony
	will automatically generate an absolute URL with HTTPS as the scheme:</p>
      <div class="highlight-text"><div class="highlight"><pre># If the current scheme is HTTPS
{{ path('secure') }}
# generates /secure

# If the current scheme is HTTP
{{ path('secure') }}
# generates https://example.com/secure
	</pre></div>
      </div>
      <p>The requirement is also enforced for incoming requests. If you try to access
	the <tt class="docutils literal"><span class="pre">/secure</span></tt> path with HTTP, you will automatically be redirected to the
	same URL, but with the HTTPS scheme.</p>
      <p>The above example uses <tt class="docutils literal"><span class="pre">https</span></tt> for the <tt class="docutils literal"><span class="pre">_scheme</span></tt>, but you can also force a
	URL to always use <tt class="docutils literal"><span class="pre">http</span></tt>.</p>
      <div class="admonition-wrapper">
	<div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	  <p class="last">The Security component provides another way to enforce the HTTP scheme via
	    the <tt class="docutils literal"><span class="pre">requires_channel</span></tt> setting. This alternative method is better suited
	    to secure an "area" of your website (all URLs under <tt class="docutils literal"><span class="pre">/admin</span></tt>) or when
	    you want to secure URLs defined in a third party bundle.</p>
      </div></div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="How to define Controllers as Services" href="../controller/service.html">
      «&nbsp;How to define Controllers as Services
    </a><span class="separator">|</span>
    <a accesskey="N" title="How to Minify JavaScripts and Stylesheets with YUI Compressor" href="../assetic/yuicompressor.html">
      How to Minify JavaScripts and Stylesheets with YUI Compressor&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
