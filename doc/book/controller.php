<?php include(__DIR__.'/../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">The Controller</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="the-controller">
      <span id="index-0"></span><h1>The Controller<a class="headerlink" href="#the-controller" title="Permalink to this headline">¶</a></h1>
      <p>A controller is a PHP function you create that takes information from the
	HTTP request and constructs and returns an HTTP response (as a Symfony2
	<tt class="docutils literal"><span class="pre">Response</span></tt> object). The response could be an HTML page, an XML document,
	a serialized JSON array, an image, a redirect, a 404 error or anything else
	you can dream up. The controller contains whatever arbitrary logic <em>your
	  application</em> needs to create that response.</p>
      <p>Along the way, your controller might read information from the request, load
	a database resource, send an email, or set information on the user's session.
	But in all cases, the controller's final job is to return the <tt class="docutils literal"><span class="pre">Response</span></tt>
	object that will be delivered back to the client. There's no magic and no
	other requirements to worry about. Here are a few common examples:</p>
      <ul class="simple">
	<li><em>Controller A</em> prepares a <tt class="docutils literal"><span class="pre">Response</span></tt> object representing the content
	  for the homepage of the site.</li>
	<li><em>Controller B</em> reads the <tt class="docutils literal"><span class="pre">slug</span></tt> parameter from the request to load a
	  blog entry from the database and create a <tt class="docutils literal"><span class="pre">Response</span></tt> object displaying
	  that blog. If the <tt class="docutils literal"><span class="pre">slug</span></tt> can't be found in the database, it creates and
	  returns a <tt class="docutils literal"><span class="pre">Response</span></tt> object with a 404 status code.</li>
	<li><em>Controller C</em> handles the form submission of a contact form. It reads
	  the form information from the request, saves the contact information to
	  the database and emails the contact information to the webmaster. Finally,
	  it creates a <tt class="docutils literal"><span class="pre">Response</span></tt> object that redirects the client's browser to
	  the contact form "thank you" page.</li>
      </ul>
      <div class="section" id="requests-controller-response-lifecycle">
	<span id="index-1"></span><h2>Requests, Controller, Response Lifecycle<a class="headerlink" href="#requests-controller-response-lifecycle" title="Permalink to this headline">¶</a></h2>
	<p>Every request handled by a Symfony2 project goes through the same basic lifecycle.
	  The framework takes care of the repetitive tasks and ultimately executes a
	  controller, which houses your custom application code:</p>
	<ul class="simple">
	  <li>Each request is handled by a single front controller file (e.g. <tt class="docutils literal"><span class="pre">app.php</span></tt>
	    or <tt class="docutils literal"><span class="pre">index.php</span></tt>) that's responsible for bootstrapping the framework;</li>
	  <li>The <tt class="docutils literal"><span class="pre">Router</span></tt> reads the request information, matches that information to
	    a specific route, and determines from that route which controller should
	    be called;</li>
	  <li>The controller is executed and the code inside the controller creates and
	    returns a <tt class="docutils literal"><span class="pre">Response</span></tt> object;</li>
	  <li>The HTTP headers and content of the <tt class="docutils literal"><span class="pre">Response</span></tt> object are sent back to
	    the client.</li>
	</ul>
	<p>Creating a page is as easy as creating a controller and making a route that
	  maps a URI to that controller.</p>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">Though similarly named, a "front controller" is different from the
	      "controllers" we'll talk about in this chapter. A front controller
	      is a short PHP file that lives in your web directory and through which
	      all requests are directed. A typical application will have a production
	      front controller (e.g. <tt class="docutils literal"><span class="pre">app.php</span></tt>) and a development front controller
	      (e.g. <tt class="docutils literal"><span class="pre">app_dev.php</span></tt>). You'll likely never need to edit, view or worry
	      about the front controllers in your application.</p>
	</div></div>
      </div>
      <div class="section" id="a-simple-controller">
	<span id="index-2"></span><h2>A Simple Controller<a class="headerlink" href="#a-simple-controller" title="Permalink to this headline">¶</a></h2>
	<p>The controller is a PHP callable responsible for returning a representation
	  of the resource (most of the time an HTML representation). Though a controller
	  can be any PHP callable (a function, a method on an object, or a <tt class="docutils literal"><span class="pre">Closure</span></tt>),
	  in Symfony2, a controller is usually a single method inside a controller
	  object. Controllers are also called <em>actions</em>.</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Controller/HelloController.php</span>

<span class="k">namespace</span> <span class="nx">Acme\HelloBundle\Controller</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\HttpFoundation\Response</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">HelloController</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">indexAction</span><span class="p">(</span><span class="nv">$name</span><span class="p">)</span>
    <span class="p">{</span>
      <span class="k">return</span> <span class="k">new</span> <span class="nx">Response</span><span class="p">(</span><span class="s1">'&lt;html&gt;&lt;body&gt;Hello '</span><span class="o">.</span><span class="nv">$name</span><span class="o">.</span><span class="s1">'!&lt;/body&gt;&lt;/html&gt;'</span><span class="p">);</span>
    <span class="p">}</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">Note that the <em>controller</em> is the <tt class="docutils literal"><span class="pre">indexAction</span></tt> method, which lives
	      inside a <em>controller class</em> (<tt class="docutils literal"><span class="pre">HelloController</span></tt>). Don't be confused
	      by the naming: a <em>controller class</em> is simply a convenient way to group
	      several controllers together. Typically, the controller class will house
	      several controllers (e.g. <tt class="docutils literal"><span class="pre">updateAction</span></tt>, <tt class="docutils literal"><span class="pre">deleteAction</span></tt>, etc). A
	      controller is also sometimes referred to as an <em>action</em>.</p>
	</div></div>
	<p>This controller is pretty straightforward, but let's walk through it:</p>
	<ul class="simple">
	  <li><em>line 3</em>: Symfony2 takes advantage of PHP 5.3 namespace functionality to
	    namespace the entire controller class. The <tt class="docutils literal"><span class="pre">use</span></tt> keyword imports the
	    <tt class="docutils literal"><span class="pre">Response</span></tt> class, which our controller must return.</li>
	  <li><em>line 6</em>: The class name is the concatenation of a name for the controller
	    class and the word <tt class="docutils literal"><span class="pre">Controller</span></tt>. This is a convention that provides consistency
	    to controllers and allows them to be referenced only by the first part of
	    the name (i.e. <tt class="docutils literal"><span class="pre">Hello</span></tt>) in the routing configuration.</li>
	  <li><em>line 8</em>: Each action in a controller class is suffixed with <tt class="docutils literal"><span class="pre">Action</span></tt>
	    and is referenced in the routing configuration by the action's name (<tt class="docutils literal"><span class="pre">index</span></tt>).
	    In the next section, we'll use a route to map a URI to this action and
	    show how the route's placeholders (<tt class="docutils literal"><span class="pre">{name}</span></tt>) become arguments on the
	    action (<tt class="docutils literal"><span class="pre">$name</span></tt>).</li>
	  <li><em>line 10</em>: The controller creates and returns a <tt class="docutils literal"><span class="pre">Response</span></tt> object.</li>
	</ul>
      </div>
      <div class="section" id="mapping-a-uri-to-a-controller">
	<span id="index-3"></span><h2>Mapping a URI to a Controller<a class="headerlink" href="#mapping-a-uri-to-a-controller" title="Permalink to this headline">¶</a></h2>
	<p>Our new controller returns a simple HTML page. To render this controller
	  at a specific URL, we need to create a route to it.</p>
	<p>We'll talk about the <tt class="docutils literal"><span class="pre">Routing</span></tt> component in detail in the <a class="reference internal" href="routing.html"><em>Routing chapter</em></a>,
	  but let's create a simple route to our controller:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 130px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># src/Acme/HelloBundle/Resources/config/routing.yml</span>
<span class="l-Scalar-Plain">hello</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">pattern</span><span class="p-Indicator">:</span>      <span class="l-Scalar-Plain">/hello/{name}</span>
    <span class="l-Scalar-Plain">defaults</span><span class="p-Indicator">:</span>     <span class="p-Indicator">{</span> <span class="nv">_controller</span><span class="p-Indicator">:</span> <span class="nv">AcmeHelloBundle</span><span class="p-Indicator">:</span><span class="nv">Hello</span><span class="p-Indicator">:</span><span class="nv">index</span> <span class="p-Indicator">}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- src/Acme/HelloBundle/Resources/config/routing.xml --&gt;</span>
<span class="nt">&lt;route</span> <span class="na">id=</span><span class="s">"hello"</span> <span class="na">pattern=</span><span class="s">"/hello/{name}"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;default</span> <span class="na">key=</span><span class="s">"_controller"</span><span class="nt">&gt;</span>AcmeHelloBundle:Hello:index<span class="nt">&lt;/default&gt;</span>
<span class="nt">&lt;/route&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Resources/config/routing.php</span>
<span class="nv">$collection</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'hello'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Route</span><span class="p">(</span><span class="s1">'/hello/{name}'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'_controller'</span> <span class="o">=&gt;</span> <span class="s1">'AcmeHelloBundle:Hello:index'</span><span class="p">,</span>
<span class="p">)));</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>Going to <tt class="docutils literal"><span class="pre">/hello/ryan</span></tt> now executes the <tt class="docutils literal"><span class="pre">HelloController::indexAction()</span></tt>
	  controller and passes in <tt class="docutils literal"><span class="pre">ryan</span></tt> for the <tt class="docutils literal"><span class="pre">$name</span></tt> variable. Creating a
	  "page" means simply creating a controller method and associated route. There's
	  no hidden layers or behind-the-scenes magic.</p>
	<p>Notice the syntax used to refer to the controller: <tt class="docutils literal"><span class="pre">AcmeHelloBundle:Hello:index</span></tt>.
	  Symfony2 uses a flexible string notation to refer to different controllers.
	  This is the most common syntax and tells Symfony2 to look for a controller
	  class called <tt class="docutils literal"><span class="pre">HelloController</span></tt> inside a bundle named <tt class="docutils literal"><span class="pre">AcmeHelloBundle</span></tt>. The
	  method <tt class="docutils literal"><span class="pre">indexAction()</span></tt> is then executed.</p>
	<p>For more details on the string format used to reference different controllers,
	  see <a class="reference internal" href="routing.html#controller-string-syntax"><em>Controller Naming Pattern</em></a>.</p>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">Notice that since our controller lives in the <tt class="docutils literal"><span class="pre">AcmeHelloBundle</span></tt>, we've
	      placed the routing configuration inside the <tt class="docutils literal"><span class="pre">AcmeHelloBundle</span></tt> to stay
	      organized. To load routing configuration that lives inside a bundle, it
	      must be imported from your application's main routing resource. See
	      <a class="reference internal" href="routing.html#routing-include-external-resources"><em>Including External Routing Resources</em></a> for more information.</p>
	</div></div>
	<div class="section" id="route-parameters-as-controller-arguments">
	  <span id="route-parameters-controller-arguments"></span><span id="index-4"></span><h3>Route Parameters as Controller Arguments<a class="headerlink" href="#route-parameters-as-controller-arguments" title="Permalink to this headline">¶</a></h3>
	  <p>We already know now that the <tt class="docutils literal"><span class="pre">_controller</span></tt> parameter <tt class="docutils literal"><span class="pre">AcmeHelloBundle:Hello:index</span></tt>
	    refers to a <tt class="docutils literal"><span class="pre">HelloController::indexAction()</span></tt> method that lives inside the
	    <tt class="docutils literal"><span class="pre">AcmeHelloBundle</span></tt> bundle. What's more interesting is the arguments that are
	    passed to that method:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="o">&lt;?</span><span class="nx">php</span>
<span class="c1">// src/Acme/HelloBundle/Controller/HelloController.php</span>

<span class="k">namespace</span> <span class="nx">Acme\HelloBundle\Controller</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Bundle\FrameworkBundle\Controller\Controller</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">HelloController</span> <span class="k">extends</span> <span class="nx">Controller</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">indexAction</span><span class="p">(</span><span class="nv">$name</span><span class="p">)</span>
    <span class="p">{</span>
      <span class="c1">// ...</span>
    <span class="p">}</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>The controller has a single argument, <tt class="docutils literal"><span class="pre">$name</span></tt>, which corresponds to the
	    <tt class="docutils literal"><span class="pre">{name}</span></tt> parameter from the matched route (<tt class="docutils literal"><span class="pre">ryan</span></tt> in our example). In
	    fact, when executing your controller, Symfony2 matches each argument of
	    the controller with a parameter from the matched route. Take the following
	    example:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 130px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># src/Acme/HelloBundle/Resources/config/routing.yml</span>
<span class="l-Scalar-Plain">hello</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">pattern</span><span class="p-Indicator">:</span>      <span class="l-Scalar-Plain">/hello/{first_name}/{last_name}</span>
    <span class="l-Scalar-Plain">defaults</span><span class="p-Indicator">:</span>     <span class="p-Indicator">{</span> <span class="nv">_controller</span><span class="p-Indicator">:</span> <span class="nv">AcmeHelloBundle</span><span class="p-Indicator">:</span><span class="nv">Hello</span><span class="p-Indicator">:</span><span class="nv">index</span><span class="p-Indicator">,</span> <span class="nv">color</span><span class="p-Indicator">:</span> <span class="nv">green</span> <span class="p-Indicator">}</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- src/Acme/HelloBundle/Resources/config/routing.xml --&gt;</span>
<span class="nt">&lt;route</span> <span class="na">id=</span><span class="s">"hello"</span> <span class="na">pattern=</span><span class="s">"/hello/{first_name}/{last_name}"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;default</span> <span class="na">key=</span><span class="s">"_controller"</span><span class="nt">&gt;</span>AcmeHelloBundle:Hello:index<span class="nt">&lt;/default&gt;</span>
    <span class="nt">&lt;default</span> <span class="na">key=</span><span class="s">"color"</span><span class="nt">&gt;</span>green<span class="nt">&lt;/default&gt;</span>
<span class="nt">&lt;/route&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Resources/config/routing.php</span>
<span class="nv">$collection</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'hello'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Route</span><span class="p">(</span><span class="s1">'/hello/{first_name}/{last_name}'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'_controller'</span> <span class="o">=&gt;</span> <span class="s1">'AcmeHelloBundle:Hello:index'</span><span class="p">,</span>
    <span class="s1">'color'</span>       <span class="o">=&gt;</span> <span class="s1">'green'</span><span class="p">,</span>
<span class="p">)));</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>The controller for this can take several arguments:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">indexAction</span><span class="p">(</span><span class="nv">$first_name</span><span class="p">,</span> <span class="nv">$last_name</span><span class="p">,</span> <span class="nv">$color</span><span class="p">)</span>
<span class="p">{</span>
    <span class="c1">// ...</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>Notice that both placeholder variables (<tt class="docutils literal"><span class="pre">{{first_name}}</span></tt>, <tt class="docutils literal"><span class="pre">{{last_name}}</span></tt>)
	    as well as the default <tt class="docutils literal"><span class="pre">color</span></tt> variable are available as arguments in the
	    controller. When a route is matched, the placeholder variables are merged
	    with the <tt class="docutils literal"><span class="pre">defaults</span></tt> to make one array that's available to your controller.</p>
	  <p>Mapping route parameters to controller arguments is easy and flexible. Keep
	    the following guidelines in mind while you develop.</p>
	  <div class="section" id="the-order-of-the-controller-arguments-does-not-matter">
	    <h4>The order of the controller arguments does not matter.<a class="headerlink" href="#the-order-of-the-controller-arguments-does-not-matter" title="Permalink to this headline">¶</a></h4>
	    <p>Symfony2 is able to matches the parameter names from the route to the variable
	      names in the controller method's signature. In other words, it realizes that
	      the <tt class="docutils literal"><span class="pre">last_name</span></tt> parameter matches up with the <tt class="docutils literal"><span class="pre">$last_name</span></tt> argument.
	      The arguments of the controller could be totally reordered and still work
	      perfectly:</p>
	    <div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">indexAction</span><span class="p">(</span><span class="nv">$last_name</span><span class="p">,</span> <span class="nv">$color</span><span class="p">,</span> <span class="nv">$first_name</span><span class="p">)</span>
<span class="p">{</span>
    <span class="c1">// ..</span>
<span class="p">}</span>
	      </pre></div>
	    </div>
	  </div>
	  <div class="section" id="each-required-controller-argument-must-match-up-with-a-routing-parameter">
	    <h4>Each required controller argument must match up with a routing parameter.<a class="headerlink" href="#each-required-controller-argument-must-match-up-with-a-routing-parameter" title="Permalink to this headline">¶</a></h4>
	    <p>The following would throw a <tt class="docutils literal"><span class="pre">RuntimeException</span></tt> because there is no <tt class="docutils literal"><span class="pre">foo</span></tt>
	      parameter defined in the route:</p>
	    <div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">indexAction</span><span class="p">(</span><span class="nv">$first_name</span><span class="p">,</span> <span class="nv">$last_name</span><span class="p">,</span> <span class="nv">$color</span><span class="p">,</span> <span class="nv">$foo</span><span class="p">)</span>
<span class="p">{</span>
    <span class="c1">// ..</span>
<span class="p">}</span>
	      </pre></div>
	    </div>
	    <p>Making the argument optional, however, is perfectly ok. The following
	      example would not throw an exception:</p>
	    <div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">indexAction</span><span class="p">(</span><span class="nv">$first_name</span><span class="p">,</span> <span class="nv">$last_name</span><span class="p">,</span> <span class="nv">$color</span><span class="p">,</span> <span class="nv">$foo</span> <span class="o">=</span> <span class="s1">'bar'</span><span class="p">)</span>
<span class="p">{</span>
    <span class="c1">// ..</span>
<span class="p">}</span>
	      </pre></div>
	    </div>
	  </div>
	  <div class="section" id="not-all-routing-parameters-need-to-be-arguments-on-your-controller">
	    <h4>Not all routing parameters need to be arguments on your controller.<a class="headerlink" href="#not-all-routing-parameters-need-to-be-arguments-on-your-controller" title="Permalink to this headline">¶</a></h4>
	    <p>If, for example, the <tt class="docutils literal"><span class="pre">last_name</span></tt> weren't important for your controller,
	      you could omit it entirely:</p>
	    <div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">indexAction</span><span class="p">(</span><span class="nv">$first_name</span><span class="p">,</span> <span class="nv">$color</span><span class="p">)</span>
<span class="p">{</span>
    <span class="c1">// ..</span>
<span class="p">}</span>
	      </pre></div>
	    </div>
	    <p>In fact, the <tt class="docutils literal"><span class="pre">_controller</span></tt> route parameter itself is technically available
	      as a controller argument since it's in the <tt class="docutils literal"><span class="pre">defaults</span></tt> of the route. Of
	      course, it's generally not very useful, so it's omitted from our controller.</p>
	    <div class="admonition-wrapper">
	      <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
		<p class="last">Every route also has a special <tt class="docutils literal"><span class="pre">_route</span></tt> parameter, which is equal to
		  the name of the route that was matched (e.g. <tt class="docutils literal"><span class="pre">hello</span></tt>). Though not usually
		  useful, this is equally available as a controller argument.</p>
	    </div></div>
	  </div>
	</div>
      </div>
      <div class="section" id="the-base-controller-class">
	<h2>The Base Controller Class<a class="headerlink" href="#the-base-controller-class" title="Permalink to this headline">¶</a></h2>
	<p>For convenience, Symfony2 comes with a base <tt class="docutils literal"><span class="pre">Controller</span></tt> class that assists
	  with some of the most common controller tasks and gives your controller class
	  access to any resource it might need. By extending this <tt class="docutils literal"><span class="pre">Controller</span></tt> class,
	  you can take advantage of several helper methods.</p>
	<p>Add the <tt class="docutils literal"><span class="pre">use</span></tt> statement atop the <tt class="docutils literal"><span class="pre">Controller</span></tt> class and then modify the
	  <tt class="docutils literal"><span class="pre">HelloController</span></tt> to extend it. That's all there is to it.</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Controller/HelloController.php</span>

<span class="k">namespace</span> <span class="nx">Acme\HelloBundle\Controller</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Bundle\FrameworkBundle\Controller\Controller</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\HttpFoundation\Response</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">HelloController</span> <span class="k">extends</span> <span class="nx">Controller</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">indexAction</span><span class="p">(</span><span class="nv">$name</span><span class="p">)</span>
    <span class="p">{</span>
      <span class="k">return</span> <span class="k">new</span> <span class="nx">Response</span><span class="p">(</span><span class="s1">'&lt;html&gt;&lt;body&gt;Hello '</span><span class="o">.</span><span class="nv">$name</span><span class="o">.</span><span class="s1">'!&lt;/body&gt;&lt;/html&gt;'</span><span class="p">);</span>
    <span class="p">}</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>So far, extending the base <tt class="docutils literal"><span class="pre">Controller</span></tt> class hasn't changed anything. In
	  the next section, we'll walk through several helper methods that the base
	  controller class makes available. These methods are just shortcuts to using
	  core Symfony2 functionality that's available to you with or without the use of
	  the base <tt class="docutils literal"><span class="pre">Controller</span></tt> class. A great way to see the core functionality in
	  action is to look in the
	  <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Bundle/FrameworkBundle/Controller/Controller.html" title="Symfony\Bundle\FrameworkBundle\Controller\Controller"><span class="pre">Controller</span></a></tt> class
	  itself.</p>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">Extending the base class is a <em>choice</em> in Symfony; it contains useful
	      shortcuts but nothing mandatory. You can also extend
	      <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/DependencyInjection/ContainerAware.html" title="Symfony\Component\DependencyInjection\ContainerAware"><span class="pre">ContainerAware</span></a></tt>. The
	      service container object will then be accessible via the <tt class="docutils literal"><span class="pre">container</span></tt>
	      property and this is the only object you need to create any controller.</p>
	</div></div>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">You can also define your <a class="reference internal" href="../cookbook/controller/service.html"><em>Controllers as Services</em></a>.</p>
	</div></div>
      </div>
      <div class="section" id="common-controller-tasks">
	<span id="index-5"></span><h2>Common Controller Tasks<a class="headerlink" href="#common-controller-tasks" title="Permalink to this headline">¶</a></h2>
	<p>Though a controller can do virtually anything, most controllers will perform
	  the same basic tasks over and over again. These tasks, such as redirecting,
	  forwarding, rendering templates and accessing core services, are very easy
	  to manage in Symfony2.</p>
	<div class="section" id="redirecting">
	  <span id="index-6"></span><h3>Redirecting<a class="headerlink" href="#redirecting" title="Permalink to this headline">¶</a></h3>
	  <p>If you want to redirect the user to another page, use the <tt class="docutils literal"><span class="pre">redirect()</span></tt> method:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">indexAction</span><span class="p">()</span>
<span class="p">{</span>
    <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">redirect</span><span class="p">(</span><span class="nv">$this</span><span class="o">-&gt;</span><span class="na">generateUrl</span><span class="p">(</span><span class="s1">'homepage'</span><span class="p">));</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>The <tt class="docutils literal"><span class="pre">generateUrl()</span></tt> method is just a help function that generates the URL
	    for a given route. For more information, see the <a class="reference internal" href="routing.html"><em>Routing</em></a>
	    chapter.</p>
	  <p>By default, the <tt class="docutils literal"><span class="pre">redirect()</span></tt> method performs a 302 (temporary) redirect. To
	    perform a 301 (permanent) redirect, modify the second argument:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">indexAction</span><span class="p">()</span>
<span class="p">{</span>
    <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">redirect</span><span class="p">(</span><span class="nv">$this</span><span class="o">-&gt;</span><span class="na">generateUrl</span><span class="p">(</span><span class="s1">'homepage'</span><span class="p">),</span> <span class="mi">301</span><span class="p">);</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p>The <tt class="docutils literal"><span class="pre">redirect()</span></tt> method is simply a shortcut that creates a <tt class="docutils literal"><span class="pre">Response</span></tt>
		object that specializes in redirecting the user. It's equivalent to:</p>
	      <blockquote class="last">
		<div><p>use SymfonyComponentHttpFoundationRedirectResponse;</p>
		  <p>return new RedirectResponse($this-&gt;generateUrl('homepage'));</p>
	      </div></blockquote>
	  </div></div>
	</div>
	<div class="section" id="forwarding">
	  <span id="index-7"></span><h3>Forwarding<a class="headerlink" href="#forwarding" title="Permalink to this headline">¶</a></h3>
	  <p>You can also easily forward to another action internally with the <tt class="docutils literal"><span class="pre">forward()</span></tt>
	    method. Instead of redirecting the user's browser, it makes an internal sub-request,
	    and calls the specified controller. The <tt class="docutils literal"><span class="pre">forward()</span></tt> method returns the <tt class="docutils literal"><span class="pre">Response</span></tt>
	    object to allow for further modification if the need arises. That <tt class="docutils literal"><span class="pre">Response</span></tt>
	    object is the end-product of the internal sub-request:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">indexAction</span><span class="p">(</span><span class="nv">$name</span><span class="p">)</span>
<span class="p">{</span>
    <span class="nv">$response</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">forward</span><span class="p">(</span><span class="s1">'AcmeHelloBundle:Hello:fancy'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'name'</span>  <span class="o">=&gt;</span> <span class="nv">$name</span><span class="p">,</span>
        <span class="s1">'color'</span> <span class="o">=&gt;</span> <span class="s1">'green'</span>
    <span class="p">));</span>

    <span class="c1">// further modify the response or return it directly</span>

    <span class="k">return</span> <span class="nv">$response</span><span class="p">;</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>Notice that the <cite>forward()</cite> method uses the same string representation of
	    the controller used in the routing configuration. In this case, the target
	    controller class will be <tt class="docutils literal"><span class="pre">HelloController</span></tt> inside some <tt class="docutils literal"><span class="pre">AcmeHelloBundle</span></tt>.
	    The array passed to the method becomes the arguments on the resulting controller.
	    This same interface is used when embedding controllers into templates (see
	    <a class="reference internal" href="templating.html#templating-embedding-controller"><em>Embedding Controllers</em></a>). The target controller method should
	    look something like the following:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">fancyAction</span><span class="p">(</span><span class="nv">$name</span><span class="p">,</span> <span class="nv">$color</span><span class="p">)</span>
<span class="p">{</span>
    <span class="c1">// ... create and return a Response object</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>And just like when creating a controller for a route, the order of the arguments
	    to <tt class="docutils literal"><span class="pre">fancyAction</span></tt> doesn't matter. Symfony2 matches the index key names
	    (e.g. <tt class="docutils literal"><span class="pre">name</span></tt>) with the method argument names (e.g. <tt class="docutils literal"><span class="pre">$name</span></tt>). If you
	    change the order of the arguments, Symfony2 will still pass the correct
	    value to each variable.</p>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p>Like other base <tt class="docutils literal"><span class="pre">Controller</span></tt> methods, the <tt class="docutils literal"><span class="pre">forward</span></tt> method is just
		a shortcut for core Symfony2 functionality. A forward can be accomplished
		directly via the <tt class="docutils literal"><span class="pre">http_kernel</span></tt> service. A forward returns a <tt class="docutils literal"><span class="pre">Response</span></tt>
		object:</p>
	      <div class="last highlight-php"><div class="highlight"><pre><span class="nv">$httpKernel</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">container</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'http_kernel'</span><span class="p">);</span>
<span class="nv">$response</span> <span class="o">=</span> <span class="nv">$httpKernel</span><span class="o">-&gt;</span><span class="na">forward</span><span class="p">(</span><span class="s1">'AcmeHelloBundle:Hello:fancy'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'name'</span>  <span class="o">=&gt;</span> <span class="nv">$name</span><span class="p">,</span>
    <span class="s1">'color'</span> <span class="o">=&gt;</span> <span class="s1">'green'</span><span class="p">,</span>
<span class="p">));</span>
		</pre></div>
	      </div>
	  </div></div>
	</div>
	<div class="section" id="rendering-templates">
	  <span id="controller-rendering-templates"></span><span id="index-8"></span><h3>Rendering Templates<a class="headerlink" href="#rendering-templates" title="Permalink to this headline">¶</a></h3>
	  <p>Though not a requirement, most controllers will ultimately render a template
	    that's responsible for generating the HTML (or other format) for the controller.
	    The <tt class="docutils literal"><span class="pre">renderView()</span></tt> method renders a template and returns its content. The
	    content from the template can be used to create a <tt class="docutils literal"><span class="pre">Response</span></tt> object:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$content</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">renderView</span><span class="p">(</span><span class="s1">'AcmeHelloBundle:Hello:index.html.twig'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'name'</span> <span class="o">=&gt;</span> <span class="nv">$name</span><span class="p">));</span>

<span class="k">return</span> <span class="k">new</span> <span class="nx">Response</span><span class="p">(</span><span class="nv">$content</span><span class="p">);</span>
	    </pre></div>
	  </div>
	  <p>This can even be done in just one step with the <tt class="docutils literal"><span class="pre">render()</span></tt> method, which
	    returns a <tt class="docutils literal"><span class="pre">Response</span></tt> object with the content from the template:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">render</span><span class="p">(</span><span class="s1">'AcmeHelloBundle:Hello:index.html.twig'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'name'</span> <span class="o">=&gt;</span> <span class="nv">$name</span><span class="p">));</span>
	    </pre></div>
	  </div>
	  <p>In both cases, the <tt class="docutils literal"><span class="pre">Resources/views/Hello/index.html.twig</span></tt> template inside
	    the <tt class="docutils literal"><span class="pre">AcmeHelloBundle</span></tt> will be rendered.</p>
	  <p>The Symfony templating engine is explained in great detail in the
	    <a class="reference internal" href="templating.html"><em>Templating</em></a> chapter.</p>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p>The <tt class="docutils literal"><span class="pre">renderView</span></tt> method is a shortcut to direct use of the <tt class="docutils literal"><span class="pre">templating</span></tt>
		service. The <tt class="docutils literal"><span class="pre">templating</span></tt> service can also be used directly:</p>
	      <div class="last highlight-php"><div class="highlight"><pre><span class="nv">$templating</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'templating'</span><span class="p">);</span>
<span class="nv">$content</span> <span class="o">=</span> <span class="nv">$templating</span><span class="o">-&gt;</span><span class="na">render</span><span class="p">(</span><span class="s1">'AcmeHelloBundle:Hello:index.html.twig'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'name'</span> <span class="o">=&gt;</span> <span class="nv">$name</span><span class="p">));</span>
		</pre></div>
	      </div>
	  </div></div>
	</div>
	<div class="section" id="accessing-other-services">
	  <span id="index-9"></span><h3>Accessing other Services<a class="headerlink" href="#accessing-other-services" title="Permalink to this headline">¶</a></h3>
	  <p>When extending the base controller class, you can access any Symfony2 service
	    via the <tt class="docutils literal"><span class="pre">get()</span></tt> method. Here are several common services you might need:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$request</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'request'</span><span class="p">);</span>

<span class="nv">$response</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'response'</span><span class="p">);</span>

<span class="nv">$templating</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'templating'</span><span class="p">);</span>

<span class="nv">$router</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'router'</span><span class="p">);</span>

<span class="nv">$mailer</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'mailer'</span><span class="p">);</span>
	    </pre></div>
	  </div>
	  <p>There are countless other services available and you are encouraged to define
	    your own. For more information, see the <a class="reference internal" href="service_container.html"><em>The Service Container</em></a>
	    chapter.</p>
	</div>
      </div>
      <div class="section" id="managing-errors">
	<span id="index-10"></span><h2>Managing Errors<a class="headerlink" href="#managing-errors" title="Permalink to this headline">¶</a></h2>
	<p>When things are not found, you should play well with the HTTP protocol and
	  return a 404 response. This is easily done by throwing a built-in HTTP
	  exception:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\HttpKernel\Exception\NotFoundHttpException</span><span class="p">;</span>

<span class="k">public</span> <span class="k">function</span> <span class="nf">indexAction</span><span class="p">()</span>
<span class="p">{</span>
    <span class="nv">$product</span> <span class="o">=</span> <span class="c1">// retrieve the object from database</span>
    <span class="k">if</span> <span class="p">(</span><span class="o">!</span><span class="nv">$product</span><span class="p">)</span> <span class="p">{</span>
        <span class="k">throw</span> <span class="k">new</span> <span class="nx">NotFoundHttpException</span><span class="p">(</span><span class="s1">'The product does not exist.'</span><span class="p">);</span>
    <span class="p">}</span>

    <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">render</span><span class="p">(</span><span class="o">...</span><span class="p">);</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>The <tt class="docutils literal"><span class="pre">NotFoundHttpException</span></tt> will return a 404 HTTP response back to the
	  browser. When viewing a page in debug mode, a full exception with stacktrace
	  is displayed so that the cause of the exception can be easily tracked down.</p>
	<p>Of course, you're free to throw any <tt class="docutils literal"><span class="pre">Exception</span></tt> class in your controller
	  - Symfony2 will automatically return a 500 HTTP response code.</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">throw</span> <span class="k">new</span> <span class="nx">\Exception</span><span class="p">(</span><span class="s1">'Something went wrong!'</span><span class="p">);</span>
	  </pre></div>
	</div>
	<p>In every case, a styled error page is shown to the end user and a full debug
	  error page is shown to the developer (when viewing the page in debug mode).
	  Both of these error pages can be customized.</p>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">Read the "<a class="reference internal" href="../cookbook/controller/error_pages.html"><em>How to customize Error Pages</em></a>" recipe to learn more.</p>
	</div></div>
      </div>
      <div class="section" id="managing-the-session">
	<span id="index-11"></span><h2>Managing the Session<a class="headerlink" href="#managing-the-session" title="Permalink to this headline">¶</a></h2>
	<p>Even if the HTTP protocol is stateless, Symfony2 provides a nice session object
	  that represents the client (be it a real person using a browser, a bot, or a
	  web service). Between two requests, Symfony2 stores the attributes in a cookie
	  by using the native PHP sessions.</p>
	<p>Storing and retrieving information from the session can be easily achieved
	  from any controller:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$session</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'request'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">getSession</span><span class="p">();</span>

<span class="c1">// store an attribute for reuse during a later user request</span>
<span class="nv">$session</span><span class="o">-&gt;</span><span class="na">set</span><span class="p">(</span><span class="s1">'foo'</span><span class="p">,</span> <span class="s1">'bar'</span><span class="p">);</span>

<span class="c1">// in another controller for another request</span>
<span class="nv">$foo</span> <span class="o">=</span> <span class="nv">$session</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'foo'</span><span class="p">);</span>

<span class="c1">// set the user locale</span>
<span class="nv">$session</span><span class="o">-&gt;</span><span class="na">setLocale</span><span class="p">(</span><span class="s1">'fr'</span><span class="p">);</span>
	  </pre></div>
	</div>
	<p>These attributes will remain on the user for the remainder of that user's
	  session.</p>
	<div class="section" id="flash-messages">
	  <span id="index-12"></span><h3>Flash Messages<a class="headerlink" href="#flash-messages" title="Permalink to this headline">¶</a></h3>
	  <p>You can also store small messages that will be stored on the user's session
	    for exactly one additional request. This is useful when processing a form:
	    you want to redirect and have a special message shown on the <em>next</em> request.
	    These types of messages are called "flash" messages.</p>
	  <p>Let's show an example where we're processing a form submit:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">updateAction</span><span class="p">()</span>
<span class="p">{</span>
    <span class="k">if</span> <span class="p">(</span><span class="s1">'POST'</span> <span class="o">===</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'request'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">getMethod</span><span class="p">())</span> <span class="p">{</span>
        <span class="c1">// do some sort of processing</span>

        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'session'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">setFlash</span><span class="p">(</span><span class="s1">'notice'</span><span class="p">,</span> <span class="s1">'Your changes were saved!'</span><span class="p">);</span>

        <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">redirect</span><span class="p">(</span><span class="nv">$this</span><span class="o">-&gt;</span><span class="na">generateUrl</span><span class="p">(</span><span class="o">...</span><span class="p">));</span>
    <span class="p">}</span>

    <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">render</span><span class="p">(</span><span class="o">...</span><span class="p">);</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>After processing the request, the controller sets a <tt class="docutils literal"><span class="pre">notice</span></tt> flash message
	    and then redirects. In the template of the next action, the following code
	    could be used to render the message:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 148px; ">
	      <li class="selected"><em><a href="#">Twig</a></em><div class="highlight-html+jinja" style="width: 690px; display: block; "><div class="highlight"><pre><span class="cp">{%</span> <span class="k">if</span> <span class="nv">app.session.hasFlash</span><span class="o">(</span><span class="s1">'notice'</span><span class="o">)</span> <span class="cp">%}</span>
    <span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"flash-notice"</span><span class="nt">&gt;</span>
        <span class="cp">{{</span> <span class="nv">app.session.flash</span><span class="o">(</span><span class="s1">'notice'</span><span class="o">)</span> <span class="cp">}}</span>
    <span class="nt">&lt;/div&gt;</span>
<span class="cp">{%</span> <span class="k">endif</span> <span class="cp">%}</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="o">&lt;?</span><span class="nx">php</span> <span class="k">if</span> <span class="p">(</span><span class="nv">$view</span><span class="p">[</span><span class="s1">'session'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">hasFlash</span><span class="p">(</span><span class="s1">'notice'</span><span class="p">)</span> <span class="cp">?&gt;</span><span class="x"></span>
<span class="x">    &lt;div class="flash-notice"&gt;</span>
<span class="x">        </span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'session'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">getFlash</span><span class="p">(</span><span class="s1">'notice'</span><span class="p">)</span> <span class="cp">?&gt;</span><span class="x"></span>
<span class="x">    &lt;/div&gt;</span>
<span class="cp">&lt;?php</span> <span class="k">endif</span><span class="p">;</span> <span class="cp">?&gt;</span><span class="x"></span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>By design, flash messages are meant to only live for exactly one request
	    (they're "gone in a flash"). They're designed to be used across redirects
	    exactly as we've done in this example.</p>
	</div>
      </div>
      <div class="section" id="the-response-object">
	<span id="index-13"></span><h2>The Response Object<a class="headerlink" href="#the-response-object" title="Permalink to this headline">¶</a></h2>
	<p>The only requirement for a controller is to return a <tt class="docutils literal"><span class="pre">Response</span></tt> object. The
	  <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpFoundation/Response.html" title="Symfony\Component\HttpFoundation\Response"><span class="pre">Response</span></a></tt> class is a PHP
	  abstraction around the HTTP response - the text-based message filled with HTTP
	  headers and content that's sent back to the client:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// create a simple Response with a 200 status code (the default)</span>
<span class="nv">$response</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Response</span><span class="p">(</span><span class="s1">'Hello '</span><span class="o">.</span><span class="nv">$name</span><span class="p">,</span> <span class="mi">200</span><span class="p">);</span>

<span class="c1">// create a JSON-response with a 200 status code</span>
<span class="nv">$response</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Response</span><span class="p">(</span><span class="nx">json_encode</span><span class="p">(</span><span class="k">array</span><span class="p">(</span><span class="s1">'name'</span> <span class="o">=&gt;</span> <span class="nv">$name</span><span class="p">)));</span>
<span class="nv">$response</span><span class="o">-&gt;</span><span class="na">headers</span><span class="o">-&gt;</span><span class="na">set</span><span class="p">(</span><span class="s1">'Content-Type'</span><span class="p">,</span> <span class="s1">'application/json'</span><span class="p">);</span>
	  </pre></div>
	</div>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">The <tt class="docutils literal"><span class="pre">headers</span></tt> property is a
	      <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpFoundation/HeaderBag.html" title="Symfony\Component\HttpFoundation\HeaderBag"><span class="pre">HeaderBag</span></a></tt> object with several
	      useful methods for reading and mutating the <tt class="docutils literal"><span class="pre">Response</span></tt> headers. The
	      header names are normalized so that using <tt class="docutils literal"><span class="pre">Content-Type</span></tt> is equivalent
	      to <tt class="docutils literal"><span class="pre">content-type</span></tt> or even <tt class="docutils literal"><span class="pre">content_type</span></tt>.</p>
	</div></div>
      </div>
      <div class="section" id="the-request-object">
	<span id="index-14"></span><h2>The Request Object<a class="headerlink" href="#the-request-object" title="Permalink to this headline">¶</a></h2>
	<p>Besides the values of the routing placeholders, the controller also has access
	  to the <tt class="docutils literal"><span class="pre">Request</span></tt> object when extending the base <tt class="docutils literal"><span class="pre">Controller</span></tt> class:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$request</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'request'</span><span class="p">);</span>

<span class="nv">$request</span><span class="o">-&gt;</span><span class="na">isXmlHttpRequest</span><span class="p">();</span> <span class="c1">// is it an Ajax request?</span>

<span class="nv">$request</span><span class="o">-&gt;</span><span class="na">getPreferredLanguage</span><span class="p">(</span><span class="k">array</span><span class="p">(</span><span class="s1">'en'</span><span class="p">,</span> <span class="s1">'fr'</span><span class="p">));</span>

<span class="nv">$request</span><span class="o">-&gt;</span><span class="na">query</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'page'</span><span class="p">);</span> <span class="c1">// get a $_GET parameter</span>

<span class="nv">$request</span><span class="o">-&gt;</span><span class="na">request</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'page'</span><span class="p">);</span> <span class="c1">// get a $_POST parameter</span>
	  </pre></div>
	</div>
	<p>Like the <tt class="docutils literal"><span class="pre">Response</span></tt> object, the request headers are stored in a <tt class="docutils literal"><span class="pre">HeaderBag</span></tt>
	  object and are easily accessible.</p>
      </div>
      <div class="section" id="overview">
	<span id="index-15"></span><h2>Overview<a class="headerlink" href="#overview" title="Permalink to this headline">¶</a></h2>
	<p>In Symfony, a controller is nothing more than a PHP function that contains
	  whatever arbitrary logic is needed to create and return a <tt class="docutils literal"><span class="pre">Response</span></tt> object.
	  The controller allows us to have an application with many pages while keeping
	  the logic for each page organized into different controller classes and action
	  methods.</p>
	<p>Symfony2 decides which controller should handle each request by matching
	  a route and resolving the string format of its <tt class="docutils literal"><span class="pre">_controller</span></tt> parameter
	  to a real Symfony2 controller. The arguments on that controller correspond
	  to the parameters on the route, allowing your controller access to the information
	  form the request.</p>
	<p>The controller can do anything and contain any logic, as long as it returns
	  a <tt class="docutils literal"><span class="pre">Response</span></tt> object. If you extend the base <tt class="docutils literal"><span class="pre">Controller</span></tt> class, you
	  instantly have access to all of the Symfony2 core service objects as well
	  as shortcut methods to performing the most common tasks.</p>
      </div>
      <div class="section" id="learn-more-from-the-cookbook">
	<h2>Learn more from the Cookbook<a class="headerlink" href="#learn-more-from-the-cookbook" title="Permalink to this headline">¶</a></h2>
	<ul class="simple">
	  <li><a class="reference internal" href="../cookbook/controller/service.html"><em>How to define Controllers as Services</em></a></li>
	  <li><a class="reference internal" href="../cookbook/controller/error_pages.html"><em>How to customize Error Pages</em></a></li>
	</ul>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="Creating Pages in Symfony2" href="page_creation.html">
      «&nbsp;Creating Pages in Symfony2
    </a><span class="separator">|</span>
    <a accesskey="N" title="Routing" href="routing.html">
      Routing&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
