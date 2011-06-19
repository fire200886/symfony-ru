<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">


  <div class="box_title">
    <h1 class="title_01">How to customize Error Pages</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    <div class="section" id="how-to-customize-error-pages">
      <h1>How to customize Error Pages<a class="headerlink" href="#how-to-customize-error-pages" title="Permalink to this headline">¶</a></h1>
      <p>When any exception is thrown in Symfony2, the exception is caught inside the
	<tt class="docutils literal"><span class="pre">Kernel</span></tt> class and eventually forwarded to a special controller,
	<tt class="docutils literal"><span class="pre">FrameworkBundle:Exception:show</span></tt> for handling. This controller, which lives
	inside the core <tt class="docutils literal"><span class="pre">FrameworkBundle</span></tt>, determines which error template to
	display and the status code that should be set for the given exception.</p>
      <div class="admonition-wrapper">
	<div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	  <p class="last">The customization of exception handling is actually much more powerful
	    than what's written here. An internal event, <tt class="docutils literal"><span class="pre">core.exception</span></tt>, is thrown
	    which allows complete control over exception handling. For more
	    information, see <a class="reference internal" href="../../book/internals/kernel.html#kernel-core-exception"><em>core.exception Event</em></a>.</p>
      </div></div>
      <p>All of the error templates live inside <tt class="docutils literal"><span class="pre">FrameworkBundle</span></tt>. To override the
	templates, we simply rely on the standard method for overriding templates that
	live inside a bundle. For more information, see
	<a class="reference internal" href="../../book/templating.html#overiding-bundle-templates"><em>Overriding Bundle Templates</em></a>.</p>
      <p>For example, to override the default error template that's shown to the
	end-user, create a new template located at
	<tt class="docutils literal"><span class="pre">app/Resources/FrameworkBundle/views/Exception/error.html.twig</span></tt>:</p>
      <div class="highlight-html+jinja"><div class="highlight"><pre><span class="cp">&lt;!DOCTYPE html&gt;</span>
<span class="nt">&lt;html&gt;</span>
    <span class="nt">&lt;head&gt;</span>
        <span class="nt">&lt;meta</span> <span class="na">http-equiv=</span><span class="s">"Content-Type"</span> <span class="na">content=</span><span class="s">"text/html; charset=utf-8"</span> <span class="nt">/&gt;</span>
        <span class="nt">&lt;title&gt;</span>An Error Occurred: <span class="cp">{{</span> <span class="nv">status_text</span> <span class="cp">}}</span><span class="nt">&lt;/title&gt;</span>
    <span class="nt">&lt;/head&gt;</span>
    <span class="nt">&lt;body&gt;</span>
        <span class="nt">&lt;h1&gt;</span>Oops! An Error Occurred<span class="nt">&lt;/h1&gt;</span>
        <span class="nt">&lt;h2&gt;</span>The server returned a "<span class="cp">{{</span> <span class="nv">exception.statuscode</span> <span class="cp">}}</span> <span class="cp">{{</span> <span class="nv">exception.statustext</span> <span class="cp">}}</span>".<span class="nt">&lt;/h2&gt;</span>
    <span class="nt">&lt;/body&gt;</span>
<span class="nt">&lt;/html&gt;</span>
	</pre></div>
      </div>
      <div class="admonition-wrapper">
	<div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	  <p class="last">If you're not familiar with Twig, don't worry. Twig is a simple, powerful
	    and optional templating engine that integrates with <tt class="docutils literal"><span class="pre">Symfony2</span></tt>.</p>
      </div></div>
      <p>In addition to the standard HTML error page, Symfony provides a default error
	page for many of the most common response formats, including JSON
	(<tt class="docutils literal"><span class="pre">error.json.twig</span></tt>), XML, (<tt class="docutils literal"><span class="pre">error.xml.twig</span></tt>), and even Javascript
	(<tt class="docutils literal"><span class="pre">error.js.twig</span></tt>), to name a few. To override any of these templates, just
	create a new file with the same name in the
	<tt class="docutils literal"><span class="pre">app/Resources/FrameworkBundle/views/Exception</span></tt> directory. This is the
	standard way of overriding any template that lives inside a bundle.</p>
      <div class="section" id="customizing-the-404-page-and-other-error-pages">
	<span id="cookbook-error-pages-by-status-code"></span><h2>Customizing the 404 Page and other Error Pages<a class="headerlink" href="#customizing-the-404-page-and-other-error-pages" title="Permalink to this headline">¶</a></h2>
	<p>You can also customize specific error templates according to the HTTP status
	  code. For instance, create a
	  <tt class="docutils literal"><span class="pre">app/Resources/FrameworkBundle/views/Exception/error404.html.twig</span></tt> template
	  to display a special page for 404 (page not found) errors.</p>
	<p>Symfony uses the following algorithm to determine which template to use:</p>
	<ul class="simple">
	  <li>First, it looks for a template for the given format and status code (like
	    <tt class="docutils literal"><span class="pre">error404.json.twig</span></tt>);</li>
	  <li>If it does not exist, it looks for a template for the given format (like
	    <tt class="docutils literal"><span class="pre">error.json.twig</span></tt>);</li>
	  <li>If it does not exist, it falls back to the HTML template (like
	    <tt class="docutils literal"><span class="pre">error.html.twig</span></tt>).</li>
	</ul>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">To see the full list of default error templates, see the
	      <tt class="docutils literal"><span class="pre">Resources/views/Exception</span></tt> directory of the <tt class="docutils literal"><span class="pre">FrameworkBundle</span></tt>. In a
	      standard Symfony2 installation, the <tt class="docutils literal"><span class="pre">FrameworkBundle</span></tt> can be found at
	      <tt class="docutils literal"><span class="pre">vendor/symfony/src/Symfony/Bundle/FrameworkBundle</span></tt>. Often, the easiest
	      way to customize an error page is to copy it from the <tt class="docutils literal"><span class="pre">FrameworkBundle</span></tt>
	      into <tt class="docutils literal"><span class="pre">app/Resources/FrameworkBundle/views/Exception</span></tt> and then modify it.</p>
	</div></div>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">The debug-friendly exception pages shown to the developer can even be
	      customized in the same way by creating templates such as
	      <tt class="docutils literal"><span class="pre">exception.html.twig</span></tt> for the standard HTML exception page or
	      <tt class="docutils literal"><span class="pre">exception.json.twig</span></tt> for the JSON exception page.</p>
	</div></div>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="Cookbook" href="../index.html">
      «&nbsp;Cookbook
    </a><span class="separator">|</span>
    <a accesskey="N" title="How to define Controllers as Services" href="service.html">
      How to define Controllers as Services&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
