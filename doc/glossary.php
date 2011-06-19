<?php include(__DIR__."/_doc.php")?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">Глоссарий</h1>
  </div>
  
  <div class="block_grey_lowlight_wrapper">
    <div class="block_grey_lowlight">
        <div class="column_right">
          <p>
            <br>
            Узнайте больше о главных концепциях.
          </p>
      </div>
    </div>
  </div>


  <div class="box_article doc_page">

    
    
    <div class="section" id="glossary">
      <h1>Глоссарий<a class="headerlink" href="#glossary" title="Permalink to this headline">¶</a></h1>
      <dl class="glossary docutils">
	<dt id="term-acme">Acme</dt>
	<dd><em>Acme</em> is a sample company name used in Symfony demos and documentation.
	  It's used as a namespace where you would normally use your own company's
	  name (e.g. <tt class="docutils literal"><span class="pre">Acme\BlogBundle</span></tt>).</dd>
	<dt id="term-action">Action</dt>
	<dd>An <em>action</em> is a PHP function or method that executes, for example,
	  when a given route is matched. The term action is synonymous with
	  <em>controller</em>, though a controller may also refer to an entire PHP
	  class that includes several actions. See the <a class="reference internal" href="book/controller.html"><em>Controller Chapter</em></a>.</dd>
	<dt id="term-application">Application</dt>
	<dd>An <em>Application</em> is a directory containing the <em>configuration</em> for a
	  given set of Bundles.</dd>
	<dt id="term-asset">Asset</dt>
	<dd>An <em>asset</em> is any non-executable, static component of a web application,
	  including CSS, JavaScript, images and video. Assets may be placed
	  directly in the project's <tt class="docutils literal"><span class="pre">web</span></tt> directory, or published from a <a class="reference internal" href="#term-bundle"><em class="xref std std-term">Bundle</em></a>
	  to the web directory using the <tt class="docutils literal"><span class="pre">assets:install</span></tt> console task.</dd>
	<dt id="term-bundle">Bundle</dt>
	<dd>A <em>Bundle</em> is a directory containing a set of files (PHP files,
	  stylesheets, JavaScripts, images, ...) that <em>implement</em> a single
	  feature (a blog, a forum, etc). In Symfony2, (<em>almost</em>) everything
	  lives inside a bundle. (see <a class="reference internal" href="book/page_creation.html#page-creation-bundles"><em>The Bundle System</em></a>)</dd>
	<dt id="term-controller">Controller</dt>
	<dd>A <em>controller</em> is a PHP function that houses all the logic necessary
	  to return a <tt class="docutils literal"><span class="pre">Response</span></tt> object that represents a particular page.
	  Typically, a route is mapped to a controller, which then uses information
	  from the request to process information, perform actions, and ultimately
	  construct and return a <tt class="docutils literal"><span class="pre">Response</span></tt> object.</dd>
	<dt id="term-distribution">Distribution</dt>
	<dd>A <em>Distribution</em> is a package made of the Symfony2 Components, a
	  selection of bundles, a sensible directory structure, a default
	  configuration, and an optional configuration system.</dd>
	<dt id="term-environment">Environment</dt>
	<dd>An environment is a string (e.g. <tt class="docutils literal"><span class="pre">prod</span></tt> or <tt class="docutils literal"><span class="pre">dev</span></tt>) that corresponds
	  to a specific set of configuration. The same application can be run
	  on the same machine using different configuration by running the application
	  in different environments. This is useful as it allows a single application
	  to have a <tt class="docutils literal"><span class="pre">dev</span></tt> environment built for debugging and a <tt class="docutils literal"><span class="pre">prod</span></tt> environment
	  that's optimized for speed.</dd>
	<dt id="term-firewall">Firewall</dt>
	<dd>In Symfony2, a <em>Firewall</em> doesn't have to do with networking. Instead,
	  it defines the authentication mechanisms (i.e. it handles the process
	  of determining the identity of your users), either for the whole
	  application or for just a part of it. See the
	  <a class="reference internal" href="book/security.html"><em>Security</em></a> chapters.</dd>
	<dt id="term-front-controller">Front Controller</dt>
	<dd>A <em>Front Controller</em> is a short PHP script that lives in the web directory
	  of your project. Typically, <em>all</em> requests are handled by executing
	  the same front controller, whose job is to bootstrap the Symfony
	  application.</dd>
	<dt id="term-http-specification">HTTP Specification</dt>
	<dd>The <em>Http Specification</em> is a document that describes the Hypertext
	  Transfer Protocol - a set of rules laying out the classic client-server
	  request-response communication. The specification defines the format
	  used for a request and response as well as the possible HTTP headers
	  that each may have. For more information, read the <a class="reference external" href="http://en.wikipedia.org/wiki/Hypertext_Transfer_Protocol">Http Wikipedia</a>
	  article or the <a class="reference external" href="http://www.w3.org/Protocols/rfc2616/rfc2616.html">HTTP 1.1 RFC</a>.</dd>
	<dt id="term-kernel">Kernel</dt>
	<dd>The <em>Kernel</em> is the core of Symfony2. The Kernel object handles HTTP
	  requests using all the bundles and libraries registered to it. See
	  <a class="reference internal" href="quick_tour/the_architecture.html#the-app-dir"><em>The Architecture: The Application Directory</em></a> and the
	  <a class="reference internal" href="book/internals/kernel.html"><em>Kernel</em></a> chapter.</dd>
	<dt id="term-project">Project</dt>
	<dd>A <em>Project</em> is a directory composed of an Application, a set of
	  bundles, vendor libraries, an autoloader, and web front controller
	  scripts.</dd>
	<dt id="term-service">Service</dt>
	<dd>A <em>Service</em> is a generic term for any PHP object that performs a
	  specific task. A service is usually used "globally", such as a database
	  connection object or an object that delivers email messages. In Symfony2,
	  services are often configured and retrieved from the service container.
	  An application that has many decoupled services is said to follow
	  a <a class="reference external" href="http://wikipedia.org/wiki/Service-oriented_architecture">service-oriented architecture</a>.</dd>
	<dt id="term-service-container">Service Container</dt>
	<dd>A <em>Service Container</em>, also known as a <em>Dependency Injection Container</em>,
	  is a special object that manages the instantiation of services inside
	  an application. Instead of creating services directly, the developer
	  <em>trains</em> the service container (via configuration) on how to create
	  the services. The service container takes care of lazily instantiating
	  and injecting dependent services. See <a class="reference internal" href="book/service_container.html"><em>The Service Container</em></a>
	  chapter.</dd>
	<dt id="term-vendor">Vendor</dt>
	<dd>A <em>vendor</em> is a supplier of PHP libraries and bundles including Symfony2
	  itself. Despite the usual commercial connotations of the word, vendors
	  in Symfony often (even usually) include free software. Any library you
	  add to your Symfony2 project should go in the <tt class="docutils literal"><span class="pre">vendor</span></tt> directory. See
	  <a class="reference internal" href="quick_tour/the_architecture.html#using-vendors"><em>The Architecture: Using Vendors</em></a>.</dd>
	<dt id="term-yaml">YAML</dt>
	<dd><em>YAML</em> is a recursive acronym for "YAML Ain't a Markup Language". It's a
	  lightweight, humane data serialization language used extensively in
	  Symfony2's configuration files.  See the <a class="reference internal" href="reference/YAML.html"><em>YAML</em></a> reference
	  chapter.</dd>
      </dl>
    </div>


    

  </div>


</div>
