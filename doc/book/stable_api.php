<?php include(__DIR__.'/../_doc.php')?>
<div class="column_02">
  <div class="breadcrumb">
    <a href="/">Home</a> »
    
    
    <a href="../index.html">Documentation</a> »
    <a href="index.html" accesskey="U">Book</a> »

    The Symfony2 Stable API
    

  </div>

  <div class="box_title">
    <h1 class="title_01">The Symfony2 Stable API</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="the-symfony2-stable-api">
      <h1>The Symfony2 Stable API<a class="headerlink" href="#the-symfony2-stable-api" title="Permalink to this headline">¶</a></h1>
      <p>The Symfony2 stable API is a subset of all Symfony2 published public methods
	(components and core bundles) that share the following properties:</p>
      <ul class="simple">
	<li>The namespace and class name won't change;</li>
	<li>The method name won't change;</li>
	<li>The method signature (arguments and return value type) won't change;</li>
	<li>The semantic of what the method does won't change.</li>
      </ul>
      <p>The implementation itself can change though. The only valid case for a change
	in the stable API is in order to fix a security issue.</p>
      <div class="admonition-wrapper">
	<div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	  <p class="last">The stable API is based on a whitelist. Therefore, everything not listed
	    explicitly in this document is not part of the stable API.</p>
      </div></div>
      <div class="admonition-wrapper">
	<div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	  <p class="last">This is a work in progress and the definitive list will be published when
	    Symfony2 final will be released. In the meantime, if you think that some
	    methods deserve to be in this list, please start a discussion on the
	    Symfony developer mailing-list.</p>
      </div></div>
      <div class="admonition-wrapper">
	<div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	  <p class="last">Any method part of the stable API is marked as such on the Symfony2 API
	    website (has the <tt class="docutils literal"><span class="pre">@stable</span></tt> annotation).</p>
      </div></div>
      <div class="admonition-wrapper">
	<div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	  <p class="last">Any third party bundle should also publish its own stable API.</p>
      </div></div>
      <div class="section" id="httpkernel-component">
	<h2>HttpKernel Component<a class="headerlink" href="#httpkernel-component" title="Permalink to this headline">¶</a></h2>
	<ul class="simple">
	  <li>HttpKernelInterface::<tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpKernel/HttpKernelInterface.html#handle()" title="Symfony\Component\HttpKernel\HttpKernelInterface::handle()"><span class="pre">handle()</span></a></tt></li>
	</ul>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="Profiler" href="internals/profiler.html">
      «&nbsp;Profiler
    </a><span class="separator">|</span>
    <a accesskey="N" title="Cookbook" href="../cookbook/index.html">
      Cookbook&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
