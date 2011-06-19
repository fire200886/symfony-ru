<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">How to define Controllers as Services</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="how-to-define-controllers-as-services">
      <span id="index-0"></span><h1>How to define Controllers as Services<a class="headerlink" href="#how-to-define-controllers-as-services" title="Permalink to this headline">¶</a></h1>
      <p>In the book, you've learned how easily a controller can be used when it
	extends the base
	<tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Bundle/FrameworkBundle/Controller/Controller.html" title="Symfony\Bundle\FrameworkBundle\Controller\Controller"><span class="pre">Controller</span></a></tt> class. While
	this works fine, controllers can also be specified as services.</p>
      <p>To refer to a controller that's defined as a service, use the single colon (:)
	notation. For example, suppose we've defined a service called
	<tt class="docutils literal"><span class="pre">my_controller</span></tt> and we want to forward to a method called <tt class="docutils literal"><span class="pre">indexAction()</span></tt>
	inside the service:</p>
      <div class="highlight-php"><div class="highlight"><pre><span class="nv">$this</span><span class="o">-&gt;</span><span class="na">forward</span><span class="p">(</span><span class="s1">'my_controller:indexAction'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'foo'</span> <span class="o">=&gt;</span> <span class="nv">$bar</span><span class="p">));</span>
	</pre></div>
      </div>
      <p>You need to use the same notation when defining the route <tt class="docutils literal"><span class="pre">_controller</span></tt>
	value:</p>
      <div class="highlight-yaml"><div class="highlight"><pre><span class="l-Scalar-Plain">my_controller</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">pattern</span><span class="p-Indicator">:</span>   <span class="l-Scalar-Plain">/</span>
    <span class="l-Scalar-Plain">defaults</span><span class="p-Indicator">:</span>  <span class="p-Indicator">{</span> <span class="nv">_controller</span><span class="p-Indicator">:</span> <span class="nv">my_controller</span><span class="p-Indicator">:</span><span class="nv">indexAction</span> <span class="p-Indicator">}</span>
	</pre></div>
      </div>
      <p>To use a controller in this way, it must be defined in the service container
	configuration. For more information, see the <a class="reference internal" href="../../book/service_container.html"><em>Service Container</em></a> chapter.</p>
      <p>When using a controller defined as a service, it will most likely not extend
	the base <tt class="docutils literal"><span class="pre">Controller</span></tt> class. Instead of relying on its shortcut methods,
	you'll interact directly with the services that you need. Fortunately, this is
	usually pretty easy and the base <tt class="docutils literal"><span class="pre">Controller</span></tt> class itself is a great source
	on how to perform many common tasks.</p>
      <div class="admonition-wrapper">
	<div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	  <p class="last">Specifying a controller as a service takes a little bit more work. The
	    primary advantage is that the entire controller or any services passed to
	    the controller can be modified via the service container configuration.
	    This is especially useful when developing an open-source bundle or any
	    bundle that will be used in many different projects. So, even if you don't
	    specify your controllers as services, you'll likely see this done in some
	    open-source Symfony2 bundles.</p>
      </div></div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="How to customize Error Pages" href="error_pages.html">
      «&nbsp;How to customize Error Pages
    </a><span class="separator">|</span>
    <a accesskey="N" title="How to force routes to always use HTTPS" href="../routing/scheme.html">
      How to force routes to always use HTTPS&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
