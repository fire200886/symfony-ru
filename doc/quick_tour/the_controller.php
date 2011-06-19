<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">The Controller</h1>
  </div>
  
  <div class="box_quick_tour">
    <ul class="quick_tour_list clear_fix">
      <li><a href="<?php l('doc/quick_tour/the_big_picture')?>">Общая картина</a></li> > 
      <li><a href="<?php l('doc/quick_tour/the_view')?>">Вид</a></li> > 
      <li>Контроллер</li> > 
      <li><a href="<?php l('doc/quick_tour/the_architecture')?>">Архитектура</a></li>
    </ul>
  </div>


  <div class="box_article doc_page">

    
    
    <div class="section" id="the-controller">
      <h1>The Controller<a class="headerlink" href="#the-controller" title="Permalink to this headline">¶</a></h1>
      <p>Still with us after the first two parts? You are already becoming a Symfony2
	addict! Without further ado, let's discover what controllers can do for you.</p>
      <div class="section" id="using-formats">
	<h2>Using Formats<a class="headerlink" href="#using-formats" title="Permalink to this headline">¶</a></h2>
	<p>Nowadays, a web application should be able to deliver more than just HTML
	  pages. From XML for RSS feeds or Web Services, to JSON for Ajax requests,
	  there are plenty of different formats to choose from. Supporting those formats
	  in Symfony2 is straightforward. Tweak the route by adding a default value of
	  <tt class="docutils literal"><span class="pre">xml</span></tt> for the <tt class="docutils literal"><span class="pre">_format</span></tt> variable:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/DemoBundle/Controller/DemoController.php</span>
<span class="k">use</span> <span class="nx">Sensio\Bundle\FrameworkExtraBundle\Configuration\Route</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Sensio\Bundle\FrameworkExtraBundle\Configuration\Template</span><span class="p">;</span>

<span class="sd">/**</span>
<span class="sd"> * @Route("/hello/{name}", defaults={"_format"="xml"}, name="_demo_hello")</span>
<span class="sd"> * @Template()</span>
<span class="sd"> */</span>
<span class="k">public</span> <span class="k">function</span> <span class="nf">helloAction</span><span class="p">(</span><span class="nv">$name</span><span class="p">)</span>
<span class="p">{</span>
    <span class="k">return</span> <span class="k">array</span><span class="p">(</span><span class="s1">'name'</span> <span class="o">=&gt;</span> <span class="nv">$name</span><span class="p">);</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>By using the request format (as defined by the <tt class="docutils literal"><span class="pre">_format</span></tt> value), Symfony2
	  automatically selects the right template, here <tt class="docutils literal"><span class="pre">hello.xml.twig</span></tt>:</p>
	<div class="highlight-xml+php"><div class="highlight"><pre><span class="c">&lt;!-- src/Acme/DemoBundle/Resources/views/Demo/hello.xml.twig --&gt;</span>
<span class="nt">&lt;hello&gt;</span>
    <span class="nt">&lt;name&gt;</span>{{ name }}<span class="nt">&lt;/name&gt;</span>
<span class="nt">&lt;/hello&gt;</span>
	  </pre></div>
	</div>
	<p>That's all there is to it. For standard formats, Symfony2 will also
	  automatically choose the best <tt class="docutils literal"><span class="pre">Content-Type</span></tt> header for the response. If
	  you want to support different formats for a single action, use the <tt class="docutils literal"><span class="pre">{_format}</span></tt>
	  placeholder in the route pattern instead:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/DemoBundle/Controller/DemoController.php</span>
<span class="k">use</span> <span class="nx">Sensio\Bundle\FrameworkExtraBundle\Configuration\Route</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Sensio\Bundle\FrameworkExtraBundle\Configuration\Template</span><span class="p">;</span>

<span class="sd">/**</span>
<span class="sd"> * @Route("/hello/{name}.{_format}", defaults={"_format"="html"}, requirements={"_format"="html|xml|json"}, name="_demo_hello")</span>
<span class="sd"> * @Template()</span>
<span class="sd"> */</span>
<span class="k">public</span> <span class="k">function</span> <span class="nf">helloAction</span><span class="p">(</span><span class="nv">$name</span><span class="p">)</span>
<span class="p">{</span>
    <span class="k">return</span> <span class="k">array</span><span class="p">(</span><span class="s1">'name'</span> <span class="o">=&gt;</span> <span class="nv">$name</span><span class="p">);</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>The controller will now be called for URLs like <tt class="docutils literal"><span class="pre">/demo/hello/Fabien.xml</span></tt> or
	  <tt class="docutils literal"><span class="pre">/demo/hello/Fabien.json</span></tt>.</p>
	<p>The <tt class="docutils literal"><span class="pre">requirements</span></tt> entry defines regular expressions that placeholders must
	  match. In this example, if you try to request the <tt class="docutils literal"><span class="pre">/demo/hello/Fabien.js</span></tt>
	  resource, you will get a 404 HTTP error, as it does not match the <tt class="docutils literal"><span class="pre">_format</span></tt>
	  requirement.</p>
      </div>
      <div class="section" id="redirecting-and-forwarding">
	<h2>Redirecting and Forwarding<a class="headerlink" href="#redirecting-and-forwarding" title="Permalink to this headline">¶</a></h2>
	<p>If you want to redirect the user to another page, use the <tt class="docutils literal"><span class="pre">redirect()</span></tt>
	  method:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">redirect</span><span class="p">(</span><span class="nv">$this</span><span class="o">-&gt;</span><span class="na">generateUrl</span><span class="p">(</span><span class="s1">'_demo_hello'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'name'</span> <span class="o">=&gt;</span> <span class="s1">'Lucas'</span><span class="p">)));</span>
	  </pre></div>
	</div>
	<p>The <tt class="docutils literal"><span class="pre">generateUrl()</span></tt> is the same method as the <tt class="docutils literal"><span class="pre">path()</span></tt> function we used in
	  templates. It takes the route name and an array of parameters as arguments and
	  returns the associated friendly URL.</p>
	<p>You can also easily forward the action to another one with the <tt class="docutils literal"><span class="pre">forward()</span></tt>
	  method. Internally, Symfony makes a "sub-request", and returns the <tt class="docutils literal"><span class="pre">Response</span></tt>
	  object from that sub-request:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$response</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">forward</span><span class="p">(</span><span class="s1">'AcmeDemoBundle:Hello:fancy'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'name'</span> <span class="o">=&gt;</span> <span class="nv">$name</span><span class="p">,</span> <span class="s1">'color'</span> <span class="o">=&gt;</span> <span class="s1">'green'</span><span class="p">));</span>

<span class="c1">// do something with the response or return it directly</span>
	  </pre></div>
	</div>
      </div>
      <div class="section" id="getting-information-from-the-request">
	<h2>Getting information from the Request<a class="headerlink" href="#getting-information-from-the-request" title="Permalink to this headline">¶</a></h2>
	<p>Besides the values of the routing placeholders, the controller also has access
	  to the <tt class="docutils literal"><span class="pre">Request</span></tt> object:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$request</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'request'</span><span class="p">);</span>

<span class="nv">$request</span><span class="o">-&gt;</span><span class="na">isXmlHttpRequest</span><span class="p">();</span> <span class="c1">// is it an Ajax request?</span>

<span class="nv">$request</span><span class="o">-&gt;</span><span class="na">getPreferredLanguage</span><span class="p">(</span><span class="k">array</span><span class="p">(</span><span class="s1">'en'</span><span class="p">,</span> <span class="s1">'fr'</span><span class="p">));</span>

<span class="nv">$request</span><span class="o">-&gt;</span><span class="na">query</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'page'</span><span class="p">);</span> <span class="c1">// get a $_GET parameter</span>

<span class="nv">$request</span><span class="o">-&gt;</span><span class="na">request</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'page'</span><span class="p">);</span> <span class="c1">// get a $_POST parameter</span>
	  </pre></div>
	</div>
	<p>In a template, you can also access the <tt class="docutils literal"><span class="pre">Request</span></tt> object via the
	  <tt class="docutils literal"><span class="pre">app.request</span></tt> variable:</p>
	<div class="highlight-html+jinja"><div class="highlight"><pre><span class="cp">{{</span> <span class="nv">app.request.query.get</span><span class="o">(</span><span class="s1">'page'</span><span class="o">)</span> <span class="cp">}}</span>

<span class="cp">{{</span> <span class="nv">app.request.parameter</span><span class="o">(</span><span class="s1">'page'</span><span class="o">)</span> <span class="cp">}}</span>
	  </pre></div>
	</div>
      </div>
      <div class="section" id="persisting-data-in-the-session">
	<h2>Persisting Data in the Session<a class="headerlink" href="#persisting-data-in-the-session" title="Permalink to this headline">¶</a></h2>
	<p>Even if the HTTP protocol is stateless, Symfony2 provides a nice session object
	  that represents the client (be it a real person using a browser, a bot, or a
	  web service). Between two requests, Symfony2 stores the attributes in a cookie
	  by using native PHP sessions.</p>
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
	<p>You can also store small messages that will only be available for the very
	  next request:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// store a message for the very next request (in a controller)</span>
<span class="nv">$session</span><span class="o">-&gt;</span><span class="na">setFlash</span><span class="p">(</span><span class="s1">'notice'</span><span class="p">,</span> <span class="s1">'Congratulations, your action succeeded!'</span><span class="p">);</span>

<span class="c1">// display the message back in the next request (in a template)</span>
<span class="p">{{</span> <span class="nx">app</span><span class="o">.</span><span class="nx">session</span><span class="o">.</span><span class="nx">flash</span><span class="p">(</span><span class="s1">'notice'</span><span class="p">)</span> <span class="p">}}</span>
	  </pre></div>
	</div>
	<p>This is useful when you need to set a success message before redirecting
	  the user to another page (which will then show the message).</p>
      </div>
      <div class="section" id="securing-resources">
	<h2>Securing Resources<a class="headerlink" href="#securing-resources" title="Permalink to this headline">¶</a></h2>
	<p>The Symfony Standard Edition comes with a simple security configuration that
	  fits most common needs:</p>
	<div class="highlight-yaml"><div class="highlight"><pre><span class="c1"># app/config/security.yml</span>
<span class="l-Scalar-Plain">security</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">encoders</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">Symfony\Component\Security\Core\User\User</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">plaintext</span>

    <span class="l-Scalar-Plain">role_hierarchy</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">ROLE_ADMIN</span><span class="p-Indicator">:</span>       <span class="l-Scalar-Plain">ROLE_USER</span>
        <span class="l-Scalar-Plain">ROLE_SUPER_ADMIN</span><span class="p-Indicator">:</span> <span class="p-Indicator">[</span><span class="nv">ROLE_USER</span><span class="p-Indicator">,</span> <span class="nv">ROLE_ADMIN</span><span class="p-Indicator">,</span> <span class="nv">ROLE_ALLOWED_TO_SWITCH</span><span class="p-Indicator">]</span>

    <span class="l-Scalar-Plain">providers</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">in_memory</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">users</span><span class="p-Indicator">:</span>
                <span class="l-Scalar-Plain">user</span><span class="p-Indicator">:</span>  <span class="p-Indicator">{</span> <span class="nv">password</span><span class="p-Indicator">:</span> <span class="nv">userpass</span><span class="p-Indicator">,</span> <span class="nv">roles</span><span class="p-Indicator">:</span> <span class="p-Indicator">[</span> <span class="s">'ROLE_USER'</span> <span class="p-Indicator">]</span> <span class="p-Indicator">}</span>
                <span class="l-Scalar-Plain">admin</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">password</span><span class="p-Indicator">:</span> <span class="nv">adminpass</span><span class="p-Indicator">,</span> <span class="nv">roles</span><span class="p-Indicator">:</span> <span class="p-Indicator">[</span> <span class="s">'ROLE_ADMIN'</span> <span class="p-Indicator">]</span> <span class="p-Indicator">}</span>

    <span class="l-Scalar-Plain">firewalls</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">login</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">pattern</span><span class="p-Indicator">:</span>  <span class="l-Scalar-Plain">/demo/secured/login</span>
            <span class="l-Scalar-Plain">security</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">false</span>

        <span class="l-Scalar-Plain">secured_area</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">pattern</span><span class="p-Indicator">:</span>    <span class="l-Scalar-Plain">/demo/secured/.*</span>
            <span class="l-Scalar-Plain">form_login</span><span class="p-Indicator">:</span>
                <span class="l-Scalar-Plain">check_path</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">/demo/secured/login_check</span>
                <span class="l-Scalar-Plain">login_path</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">/demo/secured/login</span>
            <span class="l-Scalar-Plain">logout</span><span class="p-Indicator">:</span>
                <span class="l-Scalar-Plain">path</span><span class="p-Indicator">:</span>   <span class="l-Scalar-Plain">/demo/secured/logout</span>
                <span class="l-Scalar-Plain">target</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">/demo/</span>
	  </pre></div>
	</div>
	<p>This configuration requires users to log in for any URL starting with
	  <tt class="docutils literal"><span class="pre">/demo/secured/</span></tt> and defines two valid users: <tt class="docutils literal"><span class="pre">user</span></tt> and <tt class="docutils literal"><span class="pre">admin</span></tt>.
	  Moreover, the <tt class="docutils literal"><span class="pre">admin</span></tt> user has a <tt class="docutils literal"><span class="pre">ROLE_ADMIN</span></tt> role, which includes the
	  <tt class="docutils literal"><span class="pre">ROLE_USER</span></tt> role as well (see the <tt class="docutils literal"><span class="pre">role_hierarchy</span></tt> setting).</p>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">For readability, passwords are stored in clear text in this simple
	      configuration, but you can use any hashing algorithm by tweaking the
	      <tt class="docutils literal"><span class="pre">encoders</span></tt> section.</p>
	</div></div>
	<p>Going to the <tt class="docutils literal"><span class="pre">http://localhost/Symfony/web/app_dev.php/demo/secured/hello</span></tt>
	  URL will automatically redirect you to the login form because this resource is
	  protected by a <tt class="docutils literal"><span class="pre">firewall</span></tt>.</p>
	<p>You can also force the action to require a given role by using the <tt class="docutils literal"><span class="pre">@Secure</span></tt>
	  annotation on the controller:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Sensio\Bundle\FrameworkExtraBundle\Configuration\Route</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Sensio\Bundle\FrameworkExtraBundle\Configuration\Template</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">JMS\SecurityExtraBundle\Annotation\Secure</span><span class="p">;</span>

<span class="sd">/**</span>
<span class="sd"> * @Route("/hello/admin/{name}", name="_demo_secured_hello_admin")</span>
<span class="sd"> * @Secure(roles="ROLE_ADMIN")</span>
<span class="sd"> * @Template()</span>
<span class="sd"> */</span>
<span class="k">public</span> <span class="k">function</span> <span class="nf">helloAdminAction</span><span class="p">(</span><span class="nv">$name</span><span class="p">)</span>
<span class="p">{</span>
    <span class="k">return</span> <span class="k">array</span><span class="p">(</span><span class="s1">'name'</span> <span class="o">=&gt;</span> <span class="nv">$name</span><span class="p">);</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>Now, log in as <tt class="docutils literal"><span class="pre">user</span></tt> (who does <em>not</em> have the <tt class="docutils literal"><span class="pre">ROLE_ADMIN</span></tt> role) and
	  from the secured hello page, click on the "Hello resource secured" link.
	  Symfony2 should return a 403 HTTP status code, indicating that the user
	  is "forbidden" from accessing that resource.</p>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">The Symfony2 security layer is very flexible and comes with many different
	      user providers (like one for the Doctrine ORM) and authentication providers
	      (like HTTP basic, HTTP digest, or X509 certificates). Read the
	      "<a class="reference internal" href="../book/security.html"><em>Security</em></a>" chapter of the book for more information
	      on how to use and configure them.</p>
	</div></div>
      </div>
      <div class="section" id="caching-resources">
	<h2>Caching Resources<a class="headerlink" href="#caching-resources" title="Permalink to this headline">¶</a></h2>
	<p>As soon as your website starts to generate more traffic, you will want to
	  avoid generating the same resource again and again. Symfony2 uses HTTP cache
	  headers to manage resources cache. For simple caching strategies, use the
	  convenient <tt class="docutils literal"><span class="pre">@Cache()</span></tt> annotation:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Sensio\Bundle\FrameworkExtraBundle\Configuration\Route</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Sensio\Bundle\FrameworkExtraBundle\Configuration\Template</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache</span><span class="p">;</span>

<span class="sd">/**</span>
<span class="sd"> * @Route("/hello/{name}", name="_demo_hello")</span>
<span class="sd"> * @Template()</span>
<span class="sd"> * @Cache(maxage="86400")</span>
<span class="sd"> */</span>
<span class="k">public</span> <span class="k">function</span> <span class="nf">helloAction</span><span class="p">(</span><span class="nv">$name</span><span class="p">)</span>
<span class="p">{</span>
    <span class="k">return</span> <span class="k">array</span><span class="p">(</span><span class="s1">'name'</span> <span class="o">=&gt;</span> <span class="nv">$name</span><span class="p">);</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>In this example, the resource will be cached for a day. But you can also use
	  validation instead of expiration or a combination of both if that fits your
	  needs better.</p>
	<p>Resource caching is managed by the Symfony2 built-in reverse proxy. But because
	  caching is managed using regular HTTP cache headers, you can replace the
	  built-in reverse proxy with Varnish or Squid and easily scale your application.</p>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">But what if you cannot cache whole pages? Symfony2 still has the solution
	      via Edge Side Includes (ESI), which are supported natively. Learn more by
	      reading the "<a class="reference internal" href="../book/http_cache.html"><em>HTTP Cache</em></a>" chapter of the book.</p>
	</div></div>
      </div>
      <div class="section" id="final-thoughts">
	<h2>Final Thoughts<a class="headerlink" href="#final-thoughts" title="Permalink to this headline">¶</a></h2>
	<p>That's all there is to it, and I'm not even sure we have spent the full
	  10 minutes. We briefly introduced bundles in the first part, and all the
	  features we've learned about so far are part of the core framework bundle.
	  But thanks to bundles, everything in Symfony2 can be extended or replaced.
	  That's the topic of the next part of this tutorial.</p>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="The View" href="<?php l('doc/quick_tour/the_view')?>">
      «&nbsp;The View
    </a><span class="separator">|</span>
    <a accesskey="N" title="The Architecture" href="<?php l('doc/quick_tour/the_architecture')?>">
      The Architecture&nbsp;»
    </a>
  </div>

</div>
