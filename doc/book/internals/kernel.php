<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">Kernel</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="kernel">
      <span id="index-0"></span><h1>Kernel<a class="headerlink" href="#kernel" title="Permalink to this headline">¶</a></h1>
      <p>The <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpKernel/HttpKernel.html" title="Symfony\Component\HttpKernel\HttpKernel"><span class="pre">HttpKernel</span></a></tt> class is the central
	class of Symfony2 and is responsible for handling client requests. Its main
	goal is to "convert" a <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpFoundation/Request.html" title="Symfony\Component\HttpFoundation\Request"><span class="pre">Request</span></a></tt>
	object to a <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpFoundation/Response.html" title="Symfony\Component\HttpFoundation\Response"><span class="pre">Response</span></a></tt> object.</p>
      <p>Every Symfony2 Kernel implements
	<tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpKernel/HttpKernelInterface.html" title="Symfony\Component\HttpKernel\HttpKernelInterface"><span class="pre">HttpKernelInterface</span></a></tt>:</p>
      <div class="highlight-php"><div class="highlight"><pre><span class="k">function</span> <span class="nf">handle</span><span class="p">(</span><span class="nx">Request</span> <span class="nv">$request</span><span class="p">,</span> <span class="nv">$type</span> <span class="o">=</span> <span class="nx">self</span><span class="o">::</span><span class="na">MASTER_REQUEST</span><span class="p">,</span> <span class="nv">$catch</span> <span class="o">=</span> <span class="k">true</span><span class="p">)</span>
	</pre></div>
      </div>
      <div class="section" id="controllers">
	<span id="index-1"></span><h2>Controllers<a class="headerlink" href="#controllers" title="Permalink to this headline">¶</a></h2>
	<p>To convert a Request to a Response, the Kernel relies on a "Controller". A
	  Controller can be any valid PHP callable.</p>
	<p>The Kernel delegates the selection of what Controller should be executed
	  to an implementation of
	  <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpKernel/Controller/ControllerResolverInterface.html" title="Symfony\Component\HttpKernel\Controller\ControllerResolverInterface"><span class="pre">ControllerResolverInterface</span></a></tt>:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">getController</span><span class="p">(</span><span class="nx">Request</span> <span class="nv">$request</span><span class="p">);</span>

<span class="k">public</span> <span class="k">function</span> <span class="nf">getArguments</span><span class="p">(</span><span class="nx">Request</span> <span class="nv">$request</span><span class="p">,</span> <span class="nv">$controller</span><span class="p">);</span>
	  </pre></div>
	</div>
	<p>The
	  <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpKernel/Controller/ControllerResolverInterface.html#getController()" title="Symfony\Component\HttpKernel\Controller\ControllerResolverInterface::getController()"><span class="pre">getController()</span></a></tt>
	  method returns the Controller (a PHP callable) associated with the given
	  Request. The default implementation
	  (<tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpKernel/Controller/ControllerResolver.html" title="Symfony\Component\HttpKernel\Controller\ControllerResolver"><span class="pre">ControllerResolver</span></a></tt>)
	  looks for a <tt class="docutils literal"><span class="pre">_controller</span></tt> request attribute that represents the controller
	  name (a "class::method" string, like
	  <tt class="docutils literal"><span class="pre">Bundle\BlogBundle\PostController:indexAction</span></tt>).</p>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">The default implementation uses the
	      <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Bundle/FrameworkBundle/RequestListener.html" title="Symfony\Bundle\FrameworkBundle\RequestListener"><span class="pre">RequestListener</span></a></tt> to define the
	      <tt class="docutils literal"><span class="pre">_controller</span></tt> Request attribute (see <em class="xref std std-ref">kernel-core_request</em>).</p>
	</div></div>
	<p>The
	  <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpKernel/Controller/ControllerResolverInterface.html#getArguments()" title="Symfony\Component\HttpKernel\Controller\ControllerResolverInterface::getArguments()"><span class="pre">getArguments()</span></a></tt>
	  method returns an array of arguments to pass to the Controller callable. The
	  default implementation automatically resolves the method arguments, based on
	  the Request attributes.</p>
	<div class="admonition-wrapper">
	  <div class="sidebar"></div><div class="admonition admonition-sidebar"><p class="first sidebar-title">Matching Controller method arguments from Request attributes</p>
	    <p>For each method argument, Symfony2 tries to get the value of a Request
	      attribute with the same name. If it is not defined, the argument default
	      value is used if defined:</p>
	    <div class="last highlight-php"><div class="highlight"><pre><span class="c1">// Symfony2 will look for an 'id' attribute (mandatory)</span>
<span class="c1">// and an 'admin' one (optional)</span>
<span class="k">public</span> <span class="k">function</span> <span class="nf">showAction</span><span class="p">(</span><span class="nv">$id</span><span class="p">,</span> <span class="nv">$admin</span> <span class="o">=</span> <span class="k">true</span><span class="p">)</span>
<span class="p">{</span>
    <span class="c1">// ...</span>
<span class="p">}</span>
	      </pre></div>
	    </div>
	</div></div>
      </div>
      <div class="section" id="handling-requests">
	<span id="index-2"></span><h2>Handling Requests<a class="headerlink" href="#handling-requests" title="Permalink to this headline">¶</a></h2>
	<p>The <tt class="docutils literal"><span class="pre">handle()</span></tt> method takes a <tt class="docutils literal"><span class="pre">Request</span></tt> and <em>always</em> returns a <tt class="docutils literal"><span class="pre">Response</span></tt>.
	  To convert the <tt class="docutils literal"><span class="pre">Request</span></tt>, <tt class="docutils literal"><span class="pre">handle()</span></tt> relies on the Resolver and an ordered
	  chain of Event notifications (see the next section for more information about
	  each Event):</p>
	<ol class="arabic simple">
	  <li>Before doing anything else, the <tt class="docutils literal"><span class="pre">core.request</span></tt> event is notified -- if
	    one of the listener returns a <tt class="docutils literal"><span class="pre">Response</span></tt>, it jumps to step 8 directly;</li>
	  <li>The Resolver is called to determine the Controller to execute;</li>
	  <li>Listeners of the <tt class="docutils literal"><span class="pre">core.response</span></tt> event can now manipulate the Controller
	    callable the way they want (change it, wrap it, ...);</li>
	  <li>The Kernel checks that the Controller is actually a valid PHP callable;</li>
	  <li>The Resolver is called to determine the arguments to pass to the Controller;</li>
	  <li>The Kernel calls the Controller;</li>
	  <li>If the Controller does not return a <tt class="docutils literal"><span class="pre">Response</span></tt>, listeners of the
	    <tt class="docutils literal"><span class="pre">core.view</span></tt> event can convert the Controller return value to a <tt class="docutils literal"><span class="pre">Response</span></tt>;</li>
	  <li>Listeners of the <tt class="docutils literal"><span class="pre">core.response</span></tt> event can manipulate the <tt class="docutils literal"><span class="pre">Response</span></tt>
	    (content and headers);</li>
	  <li>The Response is returned.</li>
	</ol>
	<p>If an Exception is thrown during processing, the <tt class="docutils literal"><span class="pre">core.exception</span></tt> is
	  notified and listeners are given a change to convert the Exception to a
	  Response. If that works, the <tt class="docutils literal"><span class="pre">core.response</span></tt> event is notified; if not the
	  Exception is re-thrown.</p>
	<p>If you don't want Exceptions to be caught (for embedded requests for
	  instance), disable the <tt class="docutils literal"><span class="pre">core.exception</span></tt> event by passing <tt class="docutils literal"><span class="pre">false</span></tt> as the
	  third argument to the <tt class="docutils literal"><span class="pre">handle()</span></tt> method.</p>
      </div>
      <div class="section" id="internal-requests">
	<span id="index-3"></span><h2>Internal Requests<a class="headerlink" href="#internal-requests" title="Permalink to this headline">¶</a></h2>
	<p>At any time during the handling of a request (the 'master' one), a sub-request
	  can be handled. You can pass the request type to the <tt class="docutils literal"><span class="pre">handle()</span></tt> method (its
	  second argument):</p>
	<ul class="simple">
	  <li><tt class="docutils literal"><span class="pre">HttpKernelInterface::MASTER_REQUEST</span></tt>;</li>
	  <li><tt class="docutils literal"><span class="pre">HttpKernelInterface::SUB_REQUEST</span></tt>.</li>
	</ul>
	<p>The type is passed to all events and listeners can act accordingly (some
	  processing must only occur on the master request).</p>
      </div>
      <div class="section" id="events">
	<span id="index-4"></span><h2>Events<a class="headerlink" href="#events" title="Permalink to this headline">¶</a></h2>
	<p>Each event thrown by the Kernel is a subclass of
	  <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpKernel/Event/KernelEvent.html" title="Symfony\Component\HttpKernel\Event\KernelEvent"><span class="pre">KernelEvent</span></a></tt>. This means that
	  each event has access to the same basic information:</p>
	<ul class="simple">
	  <li><tt class="docutils literal"><span class="pre">getRequestType()</span></tt> - returns the <em>type</em> of the request
	    (<tt class="docutils literal"><span class="pre">HttpKernelInterface::MASTER_REQUEST</span></tt> or <tt class="docutils literal"><span class="pre">HttpKernelInterface::SUB_REQUEST</span></tt>);</li>
	  <li><tt class="docutils literal"><span class="pre">getKernel()</span></tt> - returns the Kernel handling the request;</li>
	  <li><tt class="docutils literal"><span class="pre">getRequest()</span></tt> - returns the current <tt class="docutils literal"><span class="pre">Request</span></tt> being handled.</li>
	</ul>
	<div class="section" id="getrequesttype">
	  <h3><tt class="docutils literal"><span class="pre">getRequestType()</span></tt><a class="headerlink" href="#getrequesttype" title="Permalink to this headline">¶</a></h3>
	  <p>The <tt class="docutils literal"><span class="pre">getRequestType()</span></tt> method allows listeners to know the type of the
	    request. For instance, if a listener must only be active for master requests,
	    add the following code at the beginning of your listener method:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\HttpKernel\HttpKernelInterface</span><span class="p">;</span>

<span class="k">if</span> <span class="p">(</span><span class="nx">HttpKernelInterface</span><span class="o">::</span><span class="na">MASTER_REQUEST</span> <span class="o">!==</span> <span class="nv">$event</span><span class="o">-&gt;</span><span class="na">getRequestType</span><span class="p">())</span> <span class="p">{</span>
    <span class="c1">// return immediately</span>
    <span class="k">return</span><span class="p">;</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p class="last">If you are not yet familiar with the Symfony2 Event Dispatcher, read the
		<a class="reference internal" href="event_dispatcher.html"><em>dedicated chapter</em></a> first.</p>
	  </div></div>
	</div>
	<div class="section" id="core-request-event">
	  <span id="kernel-core-request"></span><span id="index-5"></span><h3><tt class="docutils literal"><span class="pre">core.request</span></tt> Event<a class="headerlink" href="#core-request-event" title="Permalink to this headline">¶</a></h3>
	  <p><em>Event Class</em>: <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpKernel/Event/GetResponseEvent.html" title="Symfony\Component\HttpKernel\Event\GetResponseEvent"><span class="pre">GetResponseEvent</span></a></tt></p>
	  <p>The goal of this event is to either return a <tt class="docutils literal"><span class="pre">Response</span></tt> object immediately
	    or setup variables so that a Controller can be called after the event. Any
	    listener can return a <tt class="docutils literal"><span class="pre">Response</span></tt> object via the <tt class="docutils literal"><span class="pre">setResponse()</span></tt> method on
	    the event. In this case, all other listeners won't be called.</p>
	  <p>This event is used by <tt class="docutils literal"><span class="pre">FrameworkBundle</span></tt> to populate the <tt class="docutils literal"><span class="pre">_controller</span></tt>
	    <tt class="docutils literal"><span class="pre">Request</span></tt> attribute, via the
	    <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Bundle/FrameworkBundle/RequestListener.html" title="Symfony\Bundle\FrameworkBundle\RequestListener"><span class="pre">RequestListener</span></a></tt>. RequestListener
	    uses a <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Routing/RouterInterface.html" title="Symfony\Component\Routing\RouterInterface"><span class="pre">RouterInterface</span></a></tt> object to match
	    the <tt class="docutils literal"><span class="pre">Request</span></tt> and determine the Controller name (stored in the
	    <tt class="docutils literal"><span class="pre">_controller</span></tt> <tt class="docutils literal"><span class="pre">Request</span></tt> attribute).</p>
	</div>
	<div class="section" id="core-controller-event">
	  <span id="index-6"></span><h3><tt class="docutils literal"><span class="pre">core.controller</span></tt> Event<a class="headerlink" href="#core-controller-event" title="Permalink to this headline">¶</a></h3>
	  <p><em>Event Class</em>: <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpKernel/Event/FilterControllerEvent.html" title="Symfony\Component\HttpKernel\Event\FilterControllerEvent"><span class="pre">FilterControllerEvent</span></a></tt></p>
	  <p>This event is not used by <tt class="docutils literal"><span class="pre">FrameworkBundle</span></tt>, but can be an entry point used
	    to modify the controller that should be executed:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\HttpKernel\Event\FilterControllerEvent</span><span class="p">;</span>

<span class="k">public</span> <span class="k">function</span> <span class="nf">onCoreController</span><span class="p">(</span><span class="nx">FilterControllerEvent</span> <span class="nv">$event</span><span class="p">)</span>
<span class="p">{</span>
    <span class="nv">$controller</span> <span class="o">=</span> <span class="nv">$event</span><span class="o">-&gt;</span><span class="na">getController</span><span class="p">();</span>
    <span class="c1">// ...</span>

    <span class="c1">// the controller can be changed to any PHP callable</span>
    <span class="nv">$event</span><span class="o">-&gt;</span><span class="na">setController</span><span class="p">(</span><span class="nv">$controller</span><span class="p">);</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	</div>
	<div class="section" id="core-view-event">
	  <span id="index-7"></span><h3><tt class="docutils literal"><span class="pre">core.view</span></tt> Event<a class="headerlink" href="#core-view-event" title="Permalink to this headline">¶</a></h3>
	  <p><em>Event Class</em>: <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpKernel/Event/GetResponseForControllerResultEvent.html" title="Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent"><span class="pre">GetResponseForControllerResultEvent</span></a></tt></p>
	  <p>This event is not used by <tt class="docutils literal"><span class="pre">FrameworkBundle</span></tt>, but it can be used to implement
	    a view sub-system. This event is called <em>only</em> if the Controller does <em>not</em>
	    return a <tt class="docutils literal"><span class="pre">Response</span></tt> object. The purpose of the event is to allow some other
	    return value to be converted into a <tt class="docutils literal"><span class="pre">Response</span></tt>.</p>
	  <p>The value returned by the Controller is accessible via the
	    <tt class="docutils literal"><span class="pre">getControllerResult</span></tt> method:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\HttpFoundation\Response</span><span class="p">;</span>

<span class="k">public</span> <span class="k">function</span> <span class="nf">onCoreView</span><span class="p">(</span><span class="nx">GetResponseForControllerResultEvent</span> <span class="nv">$event</span><span class="p">)</span>
<span class="p">{</span>
    <span class="nv">$val</span> <span class="o">=</span> <span class="nv">$event</span><span class="o">-&gt;</span><span class="na">getReturnValue</span><span class="p">();</span>
    <span class="nv">$response</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Response</span><span class="p">();</span>
    <span class="c1">// some how customize the Response from the return value</span>

    <span class="nv">$event</span><span class="o">-&gt;</span><span class="na">setResponse</span><span class="p">(</span><span class="nv">$response</span><span class="p">);</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	</div>
	<div class="section" id="core-response-event">
	  <span id="index-8"></span><h3><tt class="docutils literal"><span class="pre">core.response</span></tt> Event<a class="headerlink" href="#core-response-event" title="Permalink to this headline">¶</a></h3>
	  <p><em>Event Class</em>: <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpKernel/Event/FilterResponseEvent.html" title="Symfony\Component\HttpKernel\Event\FilterResponseEvent"><span class="pre">FilterResponseEvent</span></a></tt></p>
	  <p>The purpose of this event is to allow other systems to modify or replace the
	    <tt class="docutils literal"><span class="pre">Response</span></tt> object after its creation:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">onCoreResponse</span><span class="p">(</span><span class="nx">FilterResponseEvent</span> <span class="nv">$event</span><span class="p">)</span>
<span class="p">{</span>
    <span class="nv">$response</span> <span class="o">=</span> <span class="nv">$event</span><span class="o">-&gt;</span><span class="na">getResponse</span><span class="p">();</span>
    <span class="c1">// .. modify the response object</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>The <tt class="docutils literal"><span class="pre">FrameworkBundle</span></tt> registers several listeners:</p>
	  <ul class="simple">
	    <li><tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpKernel/Profiler/EventListener/ProfilerListener.html" title="Symfony\Component\HttpKernel\Profiler\EventListener\ProfilerListener"><span class="pre">ProfilerListener</span></a></tt>:
	      collects data for the current request;</li>
	    <li><tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Bundle/WebProfilerBundle/EventListener/WebDebugToolbarListener.html" title="Symfony\Bundle\WebProfilerBundle\EventListener\WebDebugToolbarListener"><span class="pre">WebDebugToolbarListener</span></a></tt>:
	      injects the Web Debug Toolbar;</li>
	    <li><tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpKernel/EventListener/ResponseListener.html" title="Symfony\Component\HttpKernel\EventListener\ResponseListener"><span class="pre">ResponseListener</span></a></tt>: fixes the
	      Response <tt class="docutils literal"><span class="pre">Content-Type</span></tt> based on the request format;</li>
	    <li><tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpKernel/EventListener/EsiListener.html" title="Symfony\Component\HttpKernel\EventListener\EsiListener"><span class="pre">EsiListener</span></a></tt>: adds a
	      <tt class="docutils literal"><span class="pre">Surrogate-Control</span></tt> HTTP header when the Response needs to be parsed for
	      ESI tags.</li>
	  </ul>
	</div>
	<div class="section" id="core-exception-event">
	  <span id="kernel-core-exception"></span><span id="index-9"></span><h3><tt class="docutils literal"><span class="pre">core.exception</span></tt> Event<a class="headerlink" href="#core-exception-event" title="Permalink to this headline">¶</a></h3>
	  <p><em>Event Class</em>: <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpKernel/Event/GetResponseForExceptionEvent.html" title="Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent"><span class="pre">GetResponseForExceptionEvent</span></a></tt></p>
	  <p><tt class="docutils literal"><span class="pre">FrameworkBundle</span></tt> registers a
	    <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Bundle/FrameworkBundle/Controller/ExceptionListener.html" title="Symfony\Bundle\FrameworkBundle\Controller\ExceptionListener"><span class="pre">ExceptionListener</span></a></tt> that
	    forwards the <tt class="docutils literal"><span class="pre">Request</span></tt> to a given Controller (the value of the
	    <tt class="docutils literal"><span class="pre">exception_listener.controller</span></tt> parameter -- must be in the
	    <tt class="docutils literal"><span class="pre">class::method</span></tt> notation).</p>
	  <p>A listener on this event can create and set a <tt class="docutils literal"><span class="pre">Response</span></tt> object, create
	    and set a new <tt class="docutils literal"><span class="pre">Exception</span></tt> object, or do nothing:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\HttpFoundation\Response</span><span class="p">;</span>

<span class="k">public</span> <span class="k">function</span> <span class="nf">onCoreException</span><span class="p">(</span><span class="nx">GetResponseForExceptionEvent</span> <span class="nv">$event</span><span class="p">)</span>
<span class="p">{</span>
    <span class="nv">$exception</span> <span class="o">=</span> <span class="nv">$event</span><span class="o">-&gt;</span><span class="na">getException</span><span class="p">();</span>
    <span class="nv">$response</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Response</span><span class="p">();</span>
    <span class="c1">// setup the Response object based on the caught exception</span>
    <span class="nv">$event</span><span class="o">-&gt;</span><span class="na">setResponse</span><span class="p">(</span><span class="nv">$response</span><span class="p">);</span>

    <span class="c1">// you can alternatively set a new Exception</span>
    <span class="c1">// $exception = new \Exception('Some special exception');</span>
    <span class="c1">// $event-&gt;setException($exception);</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	</div>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="Internals Overview" href="overview.html">
      «&nbsp;Internals Overview
    </a><span class="separator">|</span>
    <a accesskey="N" title="The Event Dispatcher" href="event_dispatcher.html">
      The Event Dispatcher&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
