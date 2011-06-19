<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">Internals Overview</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="internals-overview">
      <span id="index-0"></span><h1>Internals Overview<a class="headerlink" href="#internals-overview" title="Permalink to this headline">¶</a></h1>
      <p>Looks like you want to understand how Symfony2 works and how to extend it.
	That makes me very happy! This section is an in-depth explanation of the
	Symfony2 internals.</p>
      <div class="admonition-wrapper">
	<div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	  <p class="last">You need to read this section only if you want to understand how Symfony2
	    works behind the scene, or if you want to extend Symfony2.</p>
      </div></div>
      <p>The Symfony2 code is made of several independent layers. Each layer is built
	on top of the previous one.</p>
      <div class="admonition-wrapper">
	<div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	  <p class="last">Autoloading is not managed by the framework directly; it's done
	    independently with the help of the
	    <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpFoundation/UniversalClassLoader.html" title="Symfony\Component\HttpFoundation\UniversalClassLoader"><span class="pre">UniversalClassLoader</span></a></tt> class
	    and the <tt class="docutils literal"><span class="pre">src/autoload.php</span></tt> file. Read the <a class="reference internal" href="../../cookbook/tools/autoloader.html"><em>dedicated chapter</em></a> for more information.</p>
      </div></div>
      <div class="section" id="httpfoundation-component">
	<h2><tt class="docutils literal"><span class="pre">HttpFoundation</span></tt> Component<a class="headerlink" href="#httpfoundation-component" title="Permalink to this headline">¶</a></h2>
	<p>The deepest level is the <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpFoundation.html" title="Symfony\Component\HttpFoundation"><span class="pre">HttpFoundation</span></a></tt>
	  component. HttpFoundation provides the main objects needed to deal with HTTP.
	  It is an Object-Oriented abstraction of some native PHP functions and
	  variables:</p>
	<ul class="simple">
	  <li>The <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpFoundation/Request.html" title="Symfony\Component\HttpFoundation\Request"><span class="pre">Request</span></a></tt> class abstracts
	    the main PHP global variables like <tt class="docutils literal"><span class="pre">$_GET</span></tt>, <tt class="docutils literal"><span class="pre">$_POST</span></tt>, <tt class="docutils literal"><span class="pre">$_COOKIE</span></tt>,
	    <tt class="docutils literal"><span class="pre">$_FILES</span></tt>, and <tt class="docutils literal"><span class="pre">$_SERVER</span></tt>;</li>
	  <li>The <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpFoundation/Response.html" title="Symfony\Component\HttpFoundation\Response"><span class="pre">Response</span></a></tt> class abstracts
	    some PHP functions like <tt class="docutils literal"><span class="pre">header()</span></tt>, <tt class="docutils literal"><span class="pre">setcookie()</span></tt>, and <tt class="docutils literal"><span class="pre">echo</span></tt>;</li>
	  <li>The <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpFoundation/Session.html" title="Symfony\Component\HttpFoundation\Session"><span class="pre">Session</span></a></tt> class and
	    <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpFoundation/SessionStorage/SessionStorageInterface.html" title="Symfony\Component\HttpFoundation\SessionStorage\SessionStorageInterface"><span class="pre">SessionStorageInterface</span></a></tt>
	    interface abstract session management <tt class="docutils literal"><span class="pre">session_*()</span></tt> functions.</li>
	</ul>
      </div>
      <div class="section" id="httpkernel-component">
	<h2><tt class="docutils literal"><span class="pre">HttpKernel</span></tt> Component<a class="headerlink" href="#httpkernel-component" title="Permalink to this headline">¶</a></h2>
	<p>On top of HttpFoundation is the <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpKernel.html" title="Symfony\Component\HttpKernel"><span class="pre">HttpKernel</span></a></tt>
	  component. HttpKernel handles the dynamic part of HTTP; it is a thin wrapper
	  on top of the Request and Response classes to standardize the way requests are
	  handled. It also provides extension points and tools that makes it the ideal
	  starting point to create a Web framework without too much overhead.</p>
	<p>It also optionally adds configurability and extensibility, thanks to the
	  Dependency Injection component and a powerful plugin system (bundles).</p>
	<div class="admonition-see-also admonition-wrapper">
	  <div class="seealso"></div><div class="admonition admonition-seealso"><p class="first admonition-title">See also</p>
	    <p class="last">Read more about the <a class="reference internal" href="kernel.html"><em>HttpKernel</em></a> component. Read more about
	      <a class="reference internal" href="../service_container.html"><em>Dependency Injection</em></a> and <a class="reference internal" href="../bundles.html"><em>Bundles</em></a>.</p>
	</div></div>
      </div>
      <div class="section" id="frameworkbundle-bundle">
	<h2><tt class="docutils literal"><span class="pre">FrameworkBundle</span></tt> Bundle<a class="headerlink" href="#frameworkbundle-bundle" title="Permalink to this headline">¶</a></h2>
	<p>The <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Bundle/FrameworkBundle.html" title="Symfony\Bundle\FrameworkBundle"><span class="pre">FrameworkBundle</span></a></tt> bundle is the bundle that
	  ties the main components and libraries together to make a lightweight and fast
	  MVC framework. It comes with a sensible default configuration and conventions
	  to ease the learning curve.</p>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="Symfony2 Internals" href="index.html">
      «&nbsp;Symfony2 Internals
    </a><span class="separator">|</span>
    <a accesskey="N" title="Kernel" href="kernel.html">
      Kernel&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
