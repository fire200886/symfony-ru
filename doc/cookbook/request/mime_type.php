<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">How to register a new Request Format and Mime Type</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="how-to-register-a-new-request-format-and-mime-type">
      <span id="index-0"></span><h1>How to register a new Request Format and Mime Type<a class="headerlink" href="#how-to-register-a-new-request-format-and-mime-type" title="Permalink to this headline">¶</a></h1>
      <p>Every <tt class="docutils literal"><span class="pre">Request</span></tt> has a "format" (e.g. <tt class="docutils literal"><span class="pre">html</span></tt>, <tt class="docutils literal"><span class="pre">json</span></tt>), which is used
	to determine what type of content to return in the <tt class="docutils literal"><span class="pre">Response</span></tt>. In fact,
	the request format, accessible via
	<tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpFoundation/Request.html#getRequestFormat()" title="Symfony\Component\HttpFoundation\Request::getRequestFormat()"><span class="pre">getRequestFormat()</span></a></tt>,
	is used to set the MIME type of the <tt class="docutils literal"><span class="pre">Content-Type</span></tt> header on the <tt class="docutils literal"><span class="pre">Response</span></tt>
	object. Internally, Symfony contains a map of the most common formats (e.g.
	<tt class="docutils literal"><span class="pre">html</span></tt>, <tt class="docutils literal"><span class="pre">json</span></tt>) and their associated MIME types (e.g. <tt class="docutils literal"><span class="pre">text/html</span></tt>,
	<tt class="docutils literal"><span class="pre">application/json</span></tt>). Of course, additional format-MIME type entries can
	easily be added. This document will show how you can add the <tt class="docutils literal"><span class="pre">jsonp</span></tt> format
	and corresponding MIME type.</p>
      <div class="section" id="create-an-core-request-listener">
	<h2>Create an <tt class="docutils literal"><span class="pre">core.request</span></tt> Listener<a class="headerlink" href="#create-an-core-request-listener" title="Permalink to this headline">¶</a></h2>
	<p>The key to defining a new MIME type is to create a class that will "listen" to
	  the <tt class="docutils literal"><span class="pre">core.request</span></tt> event dispatched by the Symfony kernel. The
	  <tt class="docutils literal"><span class="pre">core.request</span></tt> event is dispatched early in Symfony's request handling
	  process and allows you to modify the request object.</p>
	<p>Create the following class, replacing the path with a path to a bundle in your
	  project:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/DemoBundle/RequestListener.php</span>
<span class="k">namespace</span> <span class="nx">Acme\DemoBundle</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Symfony\Component\HttpKernel\HttpKernelInterface</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\HttpKernel\Event\GetResponseEvent</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">RequestListener</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">onCoreRequest</span><span class="p">(</span><span class="nx">GetResponseEvent</span> <span class="nv">$event</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$event</span><span class="o">-&gt;</span><span class="na">getRequest</span><span class="p">()</span><span class="o">-&gt;</span><span class="na">setFormat</span><span class="p">(</span><span class="s1">'jsonp'</span><span class="p">,</span> <span class="s1">'application/javascript'</span><span class="p">);</span>
    <span class="p">}</span>
<span class="p">}</span>
	  </pre></div>
	</div>
      </div>
      <div class="section" id="registering-your-listener">
	<h2>Registering your Listener<a class="headerlink" href="#registering-your-listener" title="Permalink to this headline">¶</a></h2>
	<p>As for any other listener, you need to add it in one of your configuration
	  file and register it as a listener by adding the <tt class="docutils literal"><span class="pre">kernel.listener</span></tt> tag:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 289px; ">
	    <li class="selected"><em><a href="#">XML</a></em><div class="highlight-xml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/config.xml --&gt;</span>
<span class="cp">&lt;?xml version="1.0" ?&gt;</span>

<span class="nt">&lt;container</span> <span class="na">xmlns=</span><span class="s">"http://symfony.com/schema/dic/services"</span>
    <span class="na">xmlns:xsi=</span><span class="s">"http://www.w3.org/2001/XMLSchema-instance"</span>
    <span class="na">xsi:schemaLocation=</span><span class="s">"http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services-1.0.xsd"</span><span class="nt">&gt;</span>

    <span class="nt">&lt;service</span> <span class="na">id=</span><span class="s">"acme.demobundle.listener.request"</span> <span class="na">class=</span><span class="s">"Acme\DemoBundle\RequestListener"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;tag</span> <span class="na">name=</span><span class="s">"kernel.listener"</span> <span class="na">event=</span><span class="s">"core.request"</span> <span class="na">method=</span><span class="s">"onCoreRequest"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;/service&gt;</span>

<span class="nt">&lt;/container&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">YAML</a></em><div class="highlight-yaml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1"># app/config/config.yml</span>
<span class="l-Scalar-Plain">services</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">acme.demobundle.listener.request</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">class</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">Acme\DemoBundle\RequestListener</span>
        <span class="l-Scalar-Plain">tags</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="p-Indicator">{</span> <span class="nv">name</span><span class="p-Indicator">:</span> <span class="nv">kernel.listener</span><span class="p-Indicator">,</span> <span class="nv">event</span><span class="p-Indicator">:</span> <span class="nv">core.request</span><span class="p-Indicator">,</span> <span class="nv">method</span><span class="p-Indicator">:</span> <span class="nv">onCoreRequest</span> <span class="p-Indicator">}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1"># app/config/config.php</span>
<span class="nv">$definition</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Definition</span><span class="p">(</span><span class="s1">'Acme\DemoBundle\RequestListener'</span><span class="p">);</span>
<span class="nv">$definition</span><span class="o">-&gt;</span><span class="na">addTag</span><span class="p">(</span><span class="s1">'kernel.listener'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'event'</span> <span class="o">=&gt;</span> <span class="s1">'core.request'</span><span class="p">,</span> <span class="s1">'method'</span> <span class="o">=&gt;</span> <span class="s1">'onCoreRequest'</span><span class="p">));</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setDefinition</span><span class="p">(</span><span class="s1">'acme.demobundle.listener.request'</span><span class="p">,</span> <span class="nv">$definition</span><span class="p">);</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>At this point, the <tt class="docutils literal"><span class="pre">acme.demobundle.listener.request</span></tt> service has been
	  configured and will be notified when the Symfony kernel dispatches the
	  <tt class="docutils literal"><span class="pre">core.request</span></tt> event.</p>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">You can also register the listener in a configuration extension class (see
	      <a class="reference internal" href="../../book/service_container.html#service-container-extension-configuration"><em>Importing Configuration via Container Extensions</em></a> for more information).</p>
	</div></div>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="How to customize a Method Behavior without using Inheritance" href="../event_dispatcher/method_behavior.html">
      «&nbsp;How to customize a Method Behavior without using Inheritance
    </a><span class="separator">|</span>
    <a accesskey="N" title="How to create a custom Data Collector" href="../profiler/data_collector.html">
      How to create a custom Data Collector&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
