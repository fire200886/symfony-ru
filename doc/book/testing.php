<?php include(__DIR__.'/../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">Testing</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="testing">
      <span id="index-0"></span><h1>Testing<a class="headerlink" href="#testing" title="Permalink to this headline">¶</a></h1>
      <p>Whenever you write a new line of code, you also potentially add new bugs.
	Automated tests should have you covered and this tutorial shows you how to
	write unit and functional tests for your Symfony2 application.</p>
      <div class="section" id="testing-framework">
	<h2>Testing Framework<a class="headerlink" href="#testing-framework" title="Permalink to this headline">¶</a></h2>
	<p>Symfony2 tests rely heavily on PHPUnit, its best practices, and some
	  conventions. This part does not document PHPUnit itself, but if you don't know
	  it yet, you can read its excellent <a class="reference external" href="http://www.phpunit.de/manual/3.5/en/">documentation</a>.</p>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">Symfony2 works with PHPUnit 3.5.11 or later.</p>
	</div></div>
	<p>The default PHPUnit configuration looks for tests under the <tt class="docutils literal"><span class="pre">Tests/</span></tt>
	  sub-directory of your bundles:</p>
	<div class="highlight-xml"><div class="highlight"><pre><span class="c">&lt;!-- app/phpunit.xml.dist --&gt;</span>

<span class="nt">&lt;phpunit</span> <span class="na">bootstrap=</span><span class="s">"../src/autoload.php"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;testsuites&gt;</span>
        <span class="nt">&lt;testsuite</span> <span class="na">name=</span><span class="s">"Project Test Suite"</span><span class="nt">&gt;</span>
            <span class="nt">&lt;directory&gt;</span>../src/*/*Bundle/Tests<span class="nt">&lt;/directory&gt;</span>
        <span class="nt">&lt;/testsuite&gt;</span>
    <span class="nt">&lt;/testsuites&gt;</span>

    ...
<span class="nt">&lt;/phpunit&gt;</span>
	  </pre></div>
	</div>
	<p>Running the test suite for a given application is straightforward:</p>
	<div class="highlight-bash"><div class="highlight"><pre><span class="c"># specify the configuration directory on the command line</span>
<span class="nv">$ </span>phpunit -c app/

<span class="c"># or run phpunit from within the application directory</span>
<span class="nv">$ </span><span class="nb">cd </span>app/
<span class="nv">$ </span>phpunit
	  </pre></div>
	</div>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">Code coverage can be generated with the <tt class="docutils literal"><span class="pre">--coverage-html</span></tt> option.</p>
	</div></div>
      </div>
      <div class="section" id="unit-tests">
	<span id="index-1"></span><h2>Unit Tests<a class="headerlink" href="#unit-tests" title="Permalink to this headline">¶</a></h2>
	<p>Writing Symfony2 unit tests is no different than writing standard PHPUnit unit
	  tests. By convention, it's recommended to replicate the bundle directory
	  structure under its <tt class="docutils literal"><span class="pre">Tests/</span></tt> sub-directory. So, write tests for the
	  <tt class="docutils literal"><span class="pre">Acme\HelloBundle\Model\Article</span></tt> class in the
	  <tt class="docutils literal"><span class="pre">Acme/HelloBundle/Tests/Model/ArticleTest.php</span></tt> file.</p>
	<p>In a unit test, autoloading is automatically enabled via the
	  <tt class="docutils literal"><span class="pre">src/autoload.php</span></tt> file (as configured by default in the <tt class="docutils literal"><span class="pre">phpunit.xml.dist</span></tt>
	  file).</p>
	<p>Running tests for a given file or directory is also very easy:</p>
	<div class="highlight-bash"><div class="highlight"><pre><span class="c"># run all tests for the Controller</span>
<span class="nv">$ </span>phpunit -c app src/Acme/HelloBundle/Tests/Controller/

<span class="c"># run all tests for the Model</span>
<span class="nv">$ </span>phpunit -c app src/Acme/HelloBundle/Tests/Model/

<span class="c"># run tests for the Article class</span>
<span class="nv">$ </span>phpunit -c app src/Acme/HelloBundle/Tests/Model/ArticleTest.php

<span class="c"># run all tests for the entire Bundle</span>
<span class="nv">$ </span>phpunit -c app src/Acme/HelloBundle/
	  </pre></div>
	</div>
      </div>
      <div class="section" id="functional-tests">
	<span id="index-2"></span><h2>Functional Tests<a class="headerlink" href="#functional-tests" title="Permalink to this headline">¶</a></h2>
	<p>Functional tests check the integration of the different layers of an
	  application (from the routing to the views). They are no different from unit
	  tests as far as PHPUnit is concerned, but they have a very specific workflow:</p>
	<ul class="simple">
	  <li>Make a request;</li>
	  <li>Test the response;</li>
	  <li>Click on a link or submit a form;</li>
	  <li>Test the response;</li>
	  <li>Rinse and repeat.</li>
	</ul>
	<p>Requests, clicks, and submissions are done by a client that knows how to talk
	  to the application. To access such a client, your tests need to extend the
	  Symfony2 <tt class="docutils literal"><span class="pre">WebTestCase</span></tt> class. The Symfony2 Standard Edition provides a
	  simple functional test for <tt class="docutils literal"><span class="pre">DemoController</span></tt> that reads as follows:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/DemoBundle/Tests/Controller/DemoControllerTest.php</span>
<span class="k">namespace</span> <span class="nx">Acme\DemoBundle\Tests\Controller</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Symfony\Bundle\FrameworkBundle\Test\WebTestCase</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">DemoControllerTest</span> <span class="k">extends</span> <span class="nx">WebTestCase</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">testIndex</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="nv">$client</span> <span class="o">=</span> <span class="nv">static</span><span class="o">::</span><span class="na">createClient</span><span class="p">();</span>

        <span class="nv">$crawler</span> <span class="o">=</span> <span class="nv">$client</span><span class="o">-&gt;</span><span class="na">request</span><span class="p">(</span><span class="s1">'GET'</span><span class="p">,</span> <span class="s1">'/demo/hello/Fabien'</span><span class="p">);</span>

        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">assertTrue</span><span class="p">(</span><span class="nv">$crawler</span><span class="o">-&gt;</span><span class="na">filter</span><span class="p">(</span><span class="s1">'html:contains("Hello Fabien")'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">count</span><span class="p">()</span> <span class="o">&gt;</span> <span class="mi">0</span><span class="p">);</span>
    <span class="p">}</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>The <tt class="docutils literal"><span class="pre">createClient()</span></tt> method returns a client tied to the current application:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$crawler</span> <span class="o">=</span> <span class="nv">$client</span><span class="o">-&gt;</span><span class="na">request</span><span class="p">(</span><span class="s1">'GET'</span><span class="p">,</span> <span class="s1">'hello/Fabien'</span><span class="p">);</span>
	  </pre></div>
	</div>
	<p>The <tt class="docutils literal"><span class="pre">request()</span></tt> method returns a <tt class="docutils literal"><span class="pre">Crawler</span></tt> object which can be used to
	  select elements in the Response, to click on links, and to submit forms.</p>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">The Crawler can only be used if the Response content is an XML or an HTML
	      document. For other content types, get the content of the Response with
	      <tt class="docutils literal"><span class="pre">$client-&gt;getResponse()-&gt;getContent()</span></tt>.</p>
	</div></div>
	<p>Click on a link by first selecting it with the Crawler using either a XPath
	  expression or a CSS selector, then use the Client to click on it:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$link</span> <span class="o">=</span> <span class="nv">$crawler</span><span class="o">-&gt;</span><span class="na">filter</span><span class="p">(</span><span class="s1">'a:contains("Greet")'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">eq</span><span class="p">(</span><span class="mi">1</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">link</span><span class="p">();</span>

<span class="nv">$crawler</span> <span class="o">=</span> <span class="nv">$client</span><span class="o">-&gt;</span><span class="na">click</span><span class="p">(</span><span class="nv">$link</span><span class="p">);</span>
	  </pre></div>
	</div>
	<p>Submitting a form is very similar; select a form button, optionally override
	  some form values, and submit the corresponding form:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$form</span> <span class="o">=</span> <span class="nv">$crawler</span><span class="o">-&gt;</span><span class="na">selectButton</span><span class="p">(</span><span class="s1">'submit'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">form</span><span class="p">();</span>

<span class="c1">// set some values</span>
<span class="nv">$form</span><span class="p">[</span><span class="s1">'name'</span><span class="p">]</span> <span class="o">=</span> <span class="s1">'Lucas'</span><span class="p">;</span>

<span class="c1">// submit the form</span>
<span class="nv">$crawler</span> <span class="o">=</span> <span class="nv">$client</span><span class="o">-&gt;</span><span class="na">submit</span><span class="p">(</span><span class="nv">$form</span><span class="p">);</span>
	  </pre></div>
	</div>
	<p>Each <tt class="docutils literal"><span class="pre">Form</span></tt> field has specialized methods depending on its type:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// fill an input field</span>
<span class="nv">$form</span><span class="p">[</span><span class="s1">'name'</span><span class="p">]</span> <span class="o">=</span> <span class="s1">'Lucas'</span><span class="p">;</span>

<span class="c1">// select an option or a radio</span>
<span class="nv">$form</span><span class="p">[</span><span class="s1">'country'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">select</span><span class="p">(</span><span class="s1">'France'</span><span class="p">);</span>

<span class="c1">// tick a checkbox</span>
<span class="nv">$form</span><span class="p">[</span><span class="s1">'like_symfony'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">tick</span><span class="p">();</span>

<span class="c1">// upload a file</span>
<span class="nv">$form</span><span class="p">[</span><span class="s1">'photo'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">upload</span><span class="p">(</span><span class="s1">'/path/to/lucas.jpg'</span><span class="p">);</span>
	  </pre></div>
	</div>
	<p>Instead of changing one field at a time, you can also pass an array of values
	  to the <tt class="docutils literal"><span class="pre">submit()</span></tt> method:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$crawler</span> <span class="o">=</span> <span class="nv">$client</span><span class="o">-&gt;</span><span class="na">submit</span><span class="p">(</span><span class="nv">$form</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'name'</span>         <span class="o">=&gt;</span> <span class="s1">'Lucas'</span><span class="p">,</span>
    <span class="s1">'country'</span>      <span class="o">=&gt;</span> <span class="s1">'France'</span><span class="p">,</span>
    <span class="s1">'like_symfony'</span> <span class="o">=&gt;</span> <span class="k">true</span><span class="p">,</span>
    <span class="s1">'photo'</span>        <span class="o">=&gt;</span> <span class="s1">'/path/to/lucas.jpg'</span><span class="p">,</span>
<span class="p">));</span>
	  </pre></div>
	</div>
	<p>Now that you can easily navigate through an application, use assertions to test
	  that it actually does what you expect it to. Use the Crawler to make assertions
	  on the DOM:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// Assert that the response matches a given CSS selector.</span>
<span class="nv">$this</span><span class="o">-&gt;</span><span class="na">assertTrue</span><span class="p">(</span><span class="nv">$crawler</span><span class="o">-&gt;</span><span class="na">filter</span><span class="p">(</span><span class="s1">'h1'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">count</span><span class="p">()</span> <span class="o">&gt;</span> <span class="mi">0</span><span class="p">);</span>
	  </pre></div>
	</div>
	<p>Or, test against the Response content directly if you just want to assert that
	  the content contains some text, or if the Response is not an XML/HTML
	  document:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$this</span><span class="o">-&gt;</span><span class="na">assertRegExp</span><span class="p">(</span><span class="s1">'/Hello Fabien/'</span><span class="p">,</span> <span class="nv">$client</span><span class="o">-&gt;</span><span class="na">getResponse</span><span class="p">()</span><span class="o">-&gt;</span><span class="na">getContent</span><span class="p">());</span>
	  </pre></div>
	</div>
	<div class="section" id="useful-assertions">
	  <span id="index-3"></span><h3>Useful Assertions<a class="headerlink" href="#useful-assertions" title="Permalink to this headline">¶</a></h3>
	  <p>After some time, you will notice that you always write the same kind of
	    assertions. To get you started faster, here is a list of the most common and
	    useful assertions:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="c1">// Assert that the response matches a given CSS selector.</span>
<span class="nv">$this</span><span class="o">-&gt;</span><span class="na">assertTrue</span><span class="p">(</span><span class="nv">$crawler</span><span class="o">-&gt;</span><span class="na">filter</span><span class="p">(</span><span class="nv">$selector</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">count</span><span class="p">()</span> <span class="o">&gt;</span> <span class="mi">0</span><span class="p">);</span>

<span class="c1">// Assert that the response matches a given CSS selector n times.</span>
<span class="nv">$this</span><span class="o">-&gt;</span><span class="na">assertEquals</span><span class="p">(</span><span class="nv">$count</span><span class="p">,</span> <span class="nv">$crawler</span><span class="o">-&gt;</span><span class="na">filter</span><span class="p">(</span><span class="nv">$selector</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">count</span><span class="p">());</span>

<span class="c1">// Assert the a response header has the given value.</span>
<span class="nv">$this</span><span class="o">-&gt;</span><span class="na">assertTrue</span><span class="p">(</span><span class="nv">$client</span><span class="o">-&gt;</span><span class="na">getResponse</span><span class="p">()</span><span class="o">-&gt;</span><span class="na">headers</span><span class="o">-&gt;</span><span class="na">contains</span><span class="p">(</span><span class="nv">$key</span><span class="p">,</span> <span class="nv">$value</span><span class="p">));</span>

<span class="c1">// Assert that the response content matches a regexp.</span>
<span class="nv">$this</span><span class="o">-&gt;</span><span class="na">assertRegExp</span><span class="p">(</span><span class="nv">$regexp</span><span class="p">,</span> <span class="nv">$client</span><span class="o">-&gt;</span><span class="na">getResponse</span><span class="p">()</span><span class="o">-&gt;</span><span class="na">getContent</span><span class="p">());</span>

<span class="c1">// Assert the response status code.</span>
<span class="nv">$this</span><span class="o">-&gt;</span><span class="na">assertTrue</span><span class="p">(</span><span class="nv">$client</span><span class="o">-&gt;</span><span class="na">getResponse</span><span class="p">()</span><span class="o">-&gt;</span><span class="na">isSuccessful</span><span class="p">());</span>
<span class="nv">$this</span><span class="o">-&gt;</span><span class="na">assertTrue</span><span class="p">(</span><span class="nv">$client</span><span class="o">-&gt;</span><span class="na">getResponse</span><span class="p">()</span><span class="o">-&gt;</span><span class="na">isNotFound</span><span class="p">());</span>
<span class="nv">$this</span><span class="o">-&gt;</span><span class="na">assertEquals</span><span class="p">(</span><span class="mi">200</span><span class="p">,</span> <span class="nv">$client</span><span class="o">-&gt;</span><span class="na">getResponse</span><span class="p">()</span><span class="o">-&gt;</span><span class="na">getStatusCode</span><span class="p">());</span>

<span class="c1">// Assert that the response status code is a redirect.</span>
<span class="nv">$this</span><span class="o">-&gt;</span><span class="na">assertTrue</span><span class="p">(</span><span class="nv">$client</span><span class="o">-&gt;</span><span class="na">getResponse</span><span class="p">()</span><span class="o">-&gt;</span><span class="na">isRedirected</span><span class="p">(</span><span class="s1">'google.com'</span><span class="p">));</span>
	    </pre></div>
	  </div>
	</div>
      </div>
      <div class="section" id="the-test-client">
	<span id="index-4"></span><h2>The Test Client<a class="headerlink" href="#the-test-client" title="Permalink to this headline">¶</a></h2>
	<p>The test Client simulates an HTTP client like a browser.</p>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">The test Client is based on the <tt class="docutils literal"><span class="pre">BrowserKit</span></tt> and the <tt class="docutils literal"><span class="pre">Crawler</span></tt>
	      components.</p>
	</div></div>
	<div class="section" id="making-requests">
	  <h3>Making Requests<a class="headerlink" href="#making-requests" title="Permalink to this headline">¶</a></h3>
	  <p>The client knows how to make requests to a Symfony2 application:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$crawler</span> <span class="o">=</span> <span class="nv">$client</span><span class="o">-&gt;</span><span class="na">request</span><span class="p">(</span><span class="s1">'GET'</span><span class="p">,</span> <span class="s1">'/hello/Fabien'</span><span class="p">);</span>
	    </pre></div>
	  </div>
	  <p>The <tt class="docutils literal"><span class="pre">request()</span></tt> method takes the HTTP method and a URL as arguments and
	    returns a <tt class="docutils literal"><span class="pre">Crawler</span></tt> instance.</p>
	  <p>Use the Crawler to find DOM elements in the Response. These elements can then
	    be used to click on links and submit forms:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$link</span> <span class="o">=</span> <span class="nv">$crawler</span><span class="o">-&gt;</span><span class="na">selectLink</span><span class="p">(</span><span class="s1">'Go elsewhere...'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">link</span><span class="p">();</span>
<span class="nv">$crawler</span> <span class="o">=</span> <span class="nv">$client</span><span class="o">-&gt;</span><span class="na">click</span><span class="p">(</span><span class="nv">$link</span><span class="p">);</span>

<span class="nv">$form</span> <span class="o">=</span> <span class="nv">$crawler</span><span class="o">-&gt;</span><span class="na">selectButton</span><span class="p">(</span><span class="s1">'validate'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">form</span><span class="p">();</span>
<span class="nv">$crawler</span> <span class="o">=</span> <span class="nv">$client</span><span class="o">-&gt;</span><span class="na">submit</span><span class="p">(</span><span class="nv">$form</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'name'</span> <span class="o">=&gt;</span> <span class="s1">'Fabien'</span><span class="p">));</span>
	    </pre></div>
	  </div>
	  <p>The <tt class="docutils literal"><span class="pre">click()</span></tt> and <tt class="docutils literal"><span class="pre">submit()</span></tt> methods both return a <tt class="docutils literal"><span class="pre">Crawler</span></tt> object.
	    These methods are the best way to browse an application as it hides a lot of
	    details. For instance, when you submit a form, it automatically detects the
	    HTTP method and the form URL, it gives you a nice API to upload files, and it
	    merges the submitted values with the form default ones, and more.</p>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p class="last">You will learn more about the <tt class="docutils literal"><span class="pre">Link</span></tt> and <tt class="docutils literal"><span class="pre">Form</span></tt> objects in the Crawler
		section below.</p>
	  </div></div>
	  <p>But you can also simulate form submissions and complex requests with the
	    additional arguments of the <tt class="docutils literal"><span class="pre">request()</span></tt> method:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="c1">// Form submission</span>
<span class="nv">$client</span><span class="o">-&gt;</span><span class="na">request</span><span class="p">(</span><span class="s1">'POST'</span><span class="p">,</span> <span class="s1">'/submit'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'name'</span> <span class="o">=&gt;</span> <span class="s1">'Fabien'</span><span class="p">));</span>

<span class="c1">// Form submission with a file upload</span>
<span class="nv">$client</span><span class="o">-&gt;</span><span class="na">request</span><span class="p">(</span><span class="s1">'POST'</span><span class="p">,</span> <span class="s1">'/submit'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'name'</span> <span class="o">=&gt;</span> <span class="s1">'Fabien'</span><span class="p">),</span> <span class="k">array</span><span class="p">(</span><span class="s1">'photo'</span> <span class="o">=&gt;</span> <span class="s1">'/path/to/photo'</span><span class="p">));</span>

<span class="c1">// Specify HTTP headers</span>
<span class="nv">$client</span><span class="o">-&gt;</span><span class="na">request</span><span class="p">(</span><span class="s1">'DELETE'</span><span class="p">,</span> <span class="s1">'/post/12'</span><span class="p">,</span> <span class="k">array</span><span class="p">(),</span> <span class="k">array</span><span class="p">(),</span> <span class="k">array</span><span class="p">(</span><span class="s1">'PHP_AUTH_USER'</span> <span class="o">=&gt;</span> <span class="s1">'username'</span><span class="p">,</span> <span class="s1">'PHP_AUTH_PW'</span> <span class="o">=&gt;</span> <span class="s1">'pa$$word'</span><span class="p">));</span>
	    </pre></div>
	  </div>
	  <p>When a request returns a redirect response, the client automatically follows
	    it. This behavior can be changed with the <tt class="docutils literal"><span class="pre">followRedirects()</span></tt> method:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$client</span><span class="o">-&gt;</span><span class="na">followRedirects</span><span class="p">(</span><span class="k">false</span><span class="p">);</span>
	    </pre></div>
	  </div>
	  <p>When the client does not follow redirects, you can force the redirection with
	    the <tt class="docutils literal"><span class="pre">followRedirect()</span></tt> method:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$crawler</span> <span class="o">=</span> <span class="nv">$client</span><span class="o">-&gt;</span><span class="na">followRedirect</span><span class="p">();</span>
	    </pre></div>
	  </div>
	  <p>Last but not least, you can force each request to be executed in its own PHP
	    process to avoid any side-effects when working with several clients in the same
	    script:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$client</span><span class="o">-&gt;</span><span class="na">insulate</span><span class="p">();</span>
	    </pre></div>
	  </div>
	</div>
	<div class="section" id="browsing">
	  <h3>Browsing<a class="headerlink" href="#browsing" title="Permalink to this headline">¶</a></h3>
	  <p>The Client supports many operations that can be done in a real browser:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$client</span><span class="o">-&gt;</span><span class="na">back</span><span class="p">();</span>
<span class="nv">$client</span><span class="o">-&gt;</span><span class="na">forward</span><span class="p">();</span>
<span class="nv">$client</span><span class="o">-&gt;</span><span class="na">reload</span><span class="p">();</span>

<span class="c1">// Clears all cookies and the history</span>
<span class="nv">$client</span><span class="o">-&gt;</span><span class="na">restart</span><span class="p">();</span>
	    </pre></div>
	  </div>
	</div>
	<div class="section" id="accessing-internal-objects">
	  <h3>Accessing Internal Objects<a class="headerlink" href="#accessing-internal-objects" title="Permalink to this headline">¶</a></h3>
	  <p>If you use the client to test your application, you might want to access the
	    client's internal objects:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$history</span>   <span class="o">=</span> <span class="nv">$client</span><span class="o">-&gt;</span><span class="na">getHistory</span><span class="p">();</span>
<span class="nv">$cookieJar</span> <span class="o">=</span> <span class="nv">$client</span><span class="o">-&gt;</span><span class="na">getCookieJar</span><span class="p">();</span>
	    </pre></div>
	  </div>
	  <p>You can also get the objects related to the latest request:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$request</span>  <span class="o">=</span> <span class="nv">$client</span><span class="o">-&gt;</span><span class="na">getRequest</span><span class="p">();</span>
<span class="nv">$response</span> <span class="o">=</span> <span class="nv">$client</span><span class="o">-&gt;</span><span class="na">getResponse</span><span class="p">();</span>
<span class="nv">$crawler</span>  <span class="o">=</span> <span class="nv">$client</span><span class="o">-&gt;</span><span class="na">getCrawler</span><span class="p">();</span>
	    </pre></div>
	  </div>
	  <p>If your requests are not insulated, you can also access the <tt class="docutils literal"><span class="pre">Container</span></tt> and
	    the <tt class="docutils literal"><span class="pre">Kernel</span></tt>:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$container</span> <span class="o">=</span> <span class="nv">$client</span><span class="o">-&gt;</span><span class="na">getContainer</span><span class="p">();</span>
<span class="nv">$kernel</span>    <span class="o">=</span> <span class="nv">$client</span><span class="o">-&gt;</span><span class="na">getKernel</span><span class="p">();</span>
	    </pre></div>
	  </div>
	</div>
	<div class="section" id="accessing-the-container">
	  <h3>Accessing the Container<a class="headerlink" href="#accessing-the-container" title="Permalink to this headline">¶</a></h3>
	  <p>It's highly recommended that a functional test only tests the Response. But
	    under certain very rare circumstances, you might want to access some internal
	    objects to write assertions. In such cases, you can access the dependency
	    injection container:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$container</span> <span class="o">=</span> <span class="nv">$client</span><span class="o">-&gt;</span><span class="na">getContainer</span><span class="p">();</span>
	    </pre></div>
	  </div>
	  <p>Be warned that this does not work if you insulate the client or if you use an
	    HTTP layer.</p>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p class="last">If the information you need to check are available from the profiler, use
		them instead.</p>
	  </div></div>
	</div>
	<div class="section" id="accessing-the-profiler-data">
	  <h3>Accessing the Profiler Data<a class="headerlink" href="#accessing-the-profiler-data" title="Permalink to this headline">¶</a></h3>
	  <p>To assert data collected by the profiler, you can get the profile for the
	    current request like this:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$profile</span> <span class="o">=</span> <span class="nv">$client</span><span class="o">-&gt;</span><span class="na">getProfile</span><span class="p">();</span>
	    </pre></div>
	  </div>
	</div>
	<div class="section" id="redirections">
	  <h3>Redirections<a class="headerlink" href="#redirections" title="Permalink to this headline">¶</a></h3>
	  <p>By default, the Client follows HTTP redirects. But if you want to get the
	    Response before the redirection and redirect yourself, calls the
	    <tt class="docutils literal"><span class="pre">followRedirects()</span></tt> method:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$client</span><span class="o">-&gt;</span><span class="na">followRedirects</span><span class="p">(</span><span class="k">false</span><span class="p">);</span>

<span class="nv">$crawler</span> <span class="o">=</span> <span class="nv">$client</span><span class="o">-&gt;</span><span class="na">request</span><span class="p">(</span><span class="s1">'GET'</span><span class="p">,</span> <span class="s1">'/'</span><span class="p">);</span>

<span class="c1">// do something with the redirect response</span>

<span class="c1">// follow the redirection manually</span>
<span class="nv">$crawler</span> <span class="o">=</span> <span class="nv">$client</span><span class="o">-&gt;</span><span class="na">followRedirect</span><span class="p">();</span>

<span class="nv">$client</span><span class="o">-&gt;</span><span class="na">followRedirects</span><span class="p">(</span><span class="k">true</span><span class="p">);</span>
	    </pre></div>
	  </div>
	</div>
      </div>
      <div class="section" id="the-crawler">
	<span id="index-5"></span><h2>The Crawler<a class="headerlink" href="#the-crawler" title="Permalink to this headline">¶</a></h2>
	<p>A Crawler instance is returned each time you make a request with the Client.
	  It allows you to traverse HTML documents, select nodes, find links and forms.</p>
	<div class="section" id="creating-a-crawler-instance">
	  <h3>Creating a Crawler Instance<a class="headerlink" href="#creating-a-crawler-instance" title="Permalink to this headline">¶</a></h3>
	  <p>A Crawler instance is automatically created for you when you make a request
	    with a Client. But you can create your own easily:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\DomCrawler\Crawler</span><span class="p">;</span>

<span class="nv">$crawler</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Crawler</span><span class="p">(</span><span class="nv">$html</span><span class="p">,</span> <span class="nv">$url</span><span class="p">);</span>
	    </pre></div>
	  </div>
	  <p>The constructor takes two arguments: the second one is the URL that is used to
	    generate absolute URLs for links and forms; the first one can be any of the
	    following:</p>
	  <ul class="simple">
	    <li>An HTML document;</li>
	    <li>An XML document;</li>
	    <li>A <tt class="docutils literal"><span class="pre">DOMDocument</span></tt> instance;</li>
	    <li>A <tt class="docutils literal"><span class="pre">DOMNodeList</span></tt> instance;</li>
	    <li>A <tt class="docutils literal"><span class="pre">DOMNode</span></tt> instance;</li>
	    <li>An array of the above elements.</li>
	  </ul>
	  <p>After creation, you can add more nodes:</p>
	  <table border="1" class="docutils">
	    <colgroup>
	      <col width="40%">
	      <col width="60%">
	    </colgroup>
	    <thead valign="bottom">
	      <tr><th class="head">Method</th>
		<th class="head">Description</th>
	      </tr>
	    </thead>
	    <tbody valign="top">
	      <tr><td><tt class="docutils literal"><span class="pre">addHTMLDocument()</span></tt></td>
		<td>An HTML document</td>
	      </tr>
	      <tr><td><tt class="docutils literal"><span class="pre">addXMLDocument()</span></tt></td>
		<td>An XML document</td>
	      </tr>
	      <tr><td><tt class="docutils literal"><span class="pre">addDOMDocument()</span></tt></td>
		<td>A <tt class="docutils literal"><span class="pre">DOMDocument</span></tt> instance</td>
	      </tr>
	      <tr><td><tt class="docutils literal"><span class="pre">addDOMNodeList()</span></tt></td>
		<td>A <tt class="docutils literal"><span class="pre">DOMNodeList</span></tt> instance</td>
	      </tr>
	      <tr><td><tt class="docutils literal"><span class="pre">addDOMNode()</span></tt></td>
		<td>A <tt class="docutils literal"><span class="pre">DOMNode</span></tt> instance</td>
	      </tr>
	      <tr><td><tt class="docutils literal"><span class="pre">addNodes()</span></tt></td>
		<td>An array of the above elements</td>
	      </tr>
	      <tr><td><tt class="docutils literal"><span class="pre">add()</span></tt></td>
		<td>Accept any of the above elements</td>
	      </tr>
	    </tbody>
	  </table>
	</div>
	<div class="section" id="traversing">
	  <h3>Traversing<a class="headerlink" href="#traversing" title="Permalink to this headline">¶</a></h3>
	  <p>Like jQuery, the Crawler has methods to traverse the DOM of an HTML/XML
	    document:</p>
	  <table border="1" class="docutils">
	    <colgroup>
	      <col width="31%">
	      <col width="69%">
	    </colgroup>
	    <thead valign="bottom">
	      <tr><th class="head">Method</th>
		<th class="head">Description</th>
	      </tr>
	    </thead>
	    <tbody valign="top">
	      <tr><td><tt class="docutils literal"><span class="pre">filter('h1')</span></tt></td>
		<td>Nodes that match the CSS selector</td>
	      </tr>
	      <tr><td><tt class="docutils literal"><span class="pre">filterXpath('h1')</span></tt></td>
		<td>Nodes that match the XPath expression</td>
	      </tr>
	      <tr><td><tt class="docutils literal"><span class="pre">eq(1)</span></tt></td>
		<td>Node for the specified index</td>
	      </tr>
	      <tr><td><tt class="docutils literal"><span class="pre">first()</span></tt></td>
		<td>First node</td>
	      </tr>
	      <tr><td><tt class="docutils literal"><span class="pre">last()</span></tt></td>
		<td>Last node</td>
	      </tr>
	      <tr><td><tt class="docutils literal"><span class="pre">siblings()</span></tt></td>
		<td>Siblings</td>
	      </tr>
	      <tr><td><tt class="docutils literal"><span class="pre">nextAll()</span></tt></td>
		<td>All following siblings</td>
	      </tr>
	      <tr><td><tt class="docutils literal"><span class="pre">previousAll()</span></tt></td>
		<td>All preceding siblings</td>
	      </tr>
	      <tr><td><tt class="docutils literal"><span class="pre">parents()</span></tt></td>
		<td>Parent nodes</td>
	      </tr>
	      <tr><td><tt class="docutils literal"><span class="pre">children()</span></tt></td>
		<td>Children</td>
	      </tr>
	      <tr><td><tt class="docutils literal"><span class="pre">reduce($lambda)</span></tt></td>
		<td>Nodes for which the callable does not return false</td>
	      </tr>
	    </tbody>
	  </table>
	  <p>You can iteratively narrow your node selection by chaining method calls as
	    each method returns a new Crawler instance for the matching nodes:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$crawler</span>
    <span class="o">-&gt;</span><span class="na">filter</span><span class="p">(</span><span class="s1">'h1'</span><span class="p">)</span>
    <span class="o">-&gt;</span><span class="na">reduce</span><span class="p">(</span><span class="k">function</span> <span class="p">(</span><span class="nv">$node</span><span class="p">,</span> <span class="nv">$i</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="k">if</span> <span class="p">(</span><span class="o">!</span><span class="nv">$node</span><span class="o">-&gt;</span><span class="na">getAttribute</span><span class="p">(</span><span class="s1">'class'</span><span class="p">))</span> <span class="p">{</span>
            <span class="k">return</span> <span class="k">false</span><span class="p">;</span>
        <span class="p">}</span>
    <span class="p">})</span>
    <span class="o">-&gt;</span><span class="na">first</span><span class="p">();</span>
	    </pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p class="last">Use the <tt class="docutils literal"><span class="pre">count()</span></tt> function to get the number of nodes stored in a Crawler:
		<tt class="docutils literal"><span class="pre">count($crawler)</span></tt></p>
	  </div></div>
	</div>
	<div class="section" id="extracting-information">
	  <h3>Extracting Information<a class="headerlink" href="#extracting-information" title="Permalink to this headline">¶</a></h3>
	  <p>The Crawler can extract information from the nodes:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="c1">// Returns the attribute value for the first node</span>
<span class="nv">$crawler</span><span class="o">-&gt;</span><span class="na">attr</span><span class="p">(</span><span class="s1">'class'</span><span class="p">);</span>

<span class="c1">// Returns the node value for the first node</span>
<span class="nv">$crawler</span><span class="o">-&gt;</span><span class="na">text</span><span class="p">();</span>

<span class="c1">// Extracts an array of attributes for all nodes (_text returns the node value)</span>
<span class="nv">$crawler</span><span class="o">-&gt;</span><span class="na">extract</span><span class="p">(</span><span class="k">array</span><span class="p">(</span><span class="s1">'_text'</span><span class="p">,</span> <span class="s1">'href'</span><span class="p">));</span>

<span class="c1">// Executes a lambda for each node and return an array of results</span>
<span class="nv">$data</span> <span class="o">=</span> <span class="nv">$crawler</span><span class="o">-&gt;</span><span class="na">each</span><span class="p">(</span><span class="k">function</span> <span class="p">(</span><span class="nv">$node</span><span class="p">,</span> <span class="nv">$i</span><span class="p">)</span>
<span class="p">{</span>
    <span class="k">return</span> <span class="nv">$node</span><span class="o">-&gt;</span><span class="na">getAttribute</span><span class="p">(</span><span class="s1">'href'</span><span class="p">);</span>
<span class="p">});</span>
	    </pre></div>
	  </div>
	</div>
	<div class="section" id="links">
	  <h3>Links<a class="headerlink" href="#links" title="Permalink to this headline">¶</a></h3>
	  <p>You can select links with the traversing methods, but the <tt class="docutils literal"><span class="pre">selectLink()</span></tt>
	    shortcut is often more convenient:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$crawler</span><span class="o">-&gt;</span><span class="na">selectLink</span><span class="p">(</span><span class="s1">'Click here'</span><span class="p">);</span>
	    </pre></div>
	  </div>
	  <p>It selects links that contain the given text, or clickable images for which
	    the <tt class="docutils literal"><span class="pre">alt</span></tt> attribute contains the given text.</p>
	  <p>The Client <tt class="docutils literal"><span class="pre">click()</span></tt> method takes a <tt class="docutils literal"><span class="pre">Link</span></tt> instance as returned by the
	    <tt class="docutils literal"><span class="pre">link()</span></tt> method:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$link</span> <span class="o">=</span> <span class="nv">$crawler</span><span class="o">-&gt;</span><span class="na">link</span><span class="p">();</span>

<span class="nv">$client</span><span class="o">-&gt;</span><span class="na">click</span><span class="p">(</span><span class="nv">$link</span><span class="p">);</span>
	    </pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p class="last">The <tt class="docutils literal"><span class="pre">links()</span></tt> method returns an array of <tt class="docutils literal"><span class="pre">Link</span></tt> objects for all nodes.</p>
	  </div></div>
	</div>
	<div class="section" id="forms">
	  <h3>Forms<a class="headerlink" href="#forms" title="Permalink to this headline">¶</a></h3>
	  <p>As for links, you select forms with the <tt class="docutils literal"><span class="pre">selectButton()</span></tt> method:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$crawler</span><span class="o">-&gt;</span><span class="na">selectButton</span><span class="p">(</span><span class="s1">'submit'</span><span class="p">);</span>
	    </pre></div>
	  </div>
	  <p>Notice that we select form buttons and not forms as a form can have several
	    buttons; if you use the traversing API, keep in mind that you must look for a
	    button.</p>
	  <p>The <tt class="docutils literal"><span class="pre">selectButton()</span></tt> method can select <tt class="docutils literal"><span class="pre">button</span></tt> tags and submit <tt class="docutils literal"><span class="pre">input</span></tt>
	    tags; it has several heuristics to find them:</p>
	  <ul class="simple">
	    <li>The <tt class="docutils literal"><span class="pre">value</span></tt> attribute value;</li>
	    <li>The <tt class="docutils literal"><span class="pre">id</span></tt> or <tt class="docutils literal"><span class="pre">alt</span></tt> attribute value for images;</li>
	    <li>The <tt class="docutils literal"><span class="pre">id</span></tt> or <tt class="docutils literal"><span class="pre">name</span></tt> attribute value for <tt class="docutils literal"><span class="pre">button</span></tt> tags.</li>
	  </ul>
	  <p>When you have a node representing a button, call the <tt class="docutils literal"><span class="pre">form()</span></tt> method to get a
	    <tt class="docutils literal"><span class="pre">Form</span></tt> instance for the form wrapping the button node:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$form</span> <span class="o">=</span> <span class="nv">$crawler</span><span class="o">-&gt;</span><span class="na">form</span><span class="p">();</span>
	    </pre></div>
	  </div>
	  <p>When calling the <tt class="docutils literal"><span class="pre">form()</span></tt> method, you can also pass an array of field values
	    that overrides the default ones:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$form</span> <span class="o">=</span> <span class="nv">$crawler</span><span class="o">-&gt;</span><span class="na">form</span><span class="p">(</span><span class="k">array</span><span class="p">(</span>
    <span class="s1">'name'</span>         <span class="o">=&gt;</span> <span class="s1">'Fabien'</span><span class="p">,</span>
    <span class="s1">'like_symfony'</span> <span class="o">=&gt;</span> <span class="k">true</span><span class="p">,</span>
<span class="p">));</span>
	    </pre></div>
	  </div>
	  <p>And if you want to simulate a specific HTTP method for the form, pass it as a
	    second argument:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$form</span> <span class="o">=</span> <span class="nv">$crawler</span><span class="o">-&gt;</span><span class="na">form</span><span class="p">(</span><span class="k">array</span><span class="p">(),</span> <span class="s1">'DELETE'</span><span class="p">);</span>
	    </pre></div>
	  </div>
	  <p>The Client can submit <tt class="docutils literal"><span class="pre">Form</span></tt> instances:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$client</span><span class="o">-&gt;</span><span class="na">submit</span><span class="p">(</span><span class="nv">$form</span><span class="p">);</span>
	    </pre></div>
	  </div>
	  <p>The field values can also be passed as a second argument of the <tt class="docutils literal"><span class="pre">submit()</span></tt>
	    method:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$client</span><span class="o">-&gt;</span><span class="na">submit</span><span class="p">(</span><span class="nv">$form</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'name'</span>         <span class="o">=&gt;</span> <span class="s1">'Fabien'</span><span class="p">,</span>
    <span class="s1">'like_symfony'</span> <span class="o">=&gt;</span> <span class="k">true</span><span class="p">,</span>
<span class="p">));</span>
	    </pre></div>
	  </div>
	  <p>For more complex situations, use the <tt class="docutils literal"><span class="pre">Form</span></tt> instance as an array to set the
	    value of each field individually:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="c1">// Change the value of a field</span>
<span class="nv">$form</span><span class="p">[</span><span class="s1">'name'</span><span class="p">]</span> <span class="o">=</span> <span class="s1">'Fabien'</span><span class="p">;</span>
	    </pre></div>
	  </div>
	  <p>There is also a nice API to manipulate the values of the fields according to
	    their type:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="c1">// Select an option or a radio</span>
<span class="nv">$form</span><span class="p">[</span><span class="s1">'country'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">select</span><span class="p">(</span><span class="s1">'France'</span><span class="p">);</span>

<span class="c1">// Tick a checkbox</span>
<span class="nv">$form</span><span class="p">[</span><span class="s1">'like_symfony'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">tick</span><span class="p">();</span>

<span class="c1">// Upload a file</span>
<span class="nv">$form</span><span class="p">[</span><span class="s1">'photo'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">upload</span><span class="p">(</span><span class="s1">'/path/to/lucas.jpg'</span><span class="p">);</span>
	    </pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p class="last">You can get the values that will be submitted by calling the <tt class="docutils literal"><span class="pre">getValues()</span></tt>
		method. The uploaded files are available in a separate array returned by
		<tt class="docutils literal"><span class="pre">getFiles()</span></tt>. The <tt class="docutils literal"><span class="pre">getPhpValues()</span></tt> and <tt class="docutils literal"><span class="pre">getPhpFiles()</span></tt> also return
		the submitted values, but in the PHP format (it converts the keys with
		square brackets notation to PHP arrays).</p>
	  </div></div>
	</div>
      </div>
      <div class="section" id="testing-configuration">
	<span id="index-6"></span><h2>Testing Configuration<a class="headerlink" href="#testing-configuration" title="Permalink to this headline">¶</a></h2>
	<div class="section" id="phpunit-configuration">
	  <span id="index-7"></span><h3>PHPUnit Configuration<a class="headerlink" href="#phpunit-configuration" title="Permalink to this headline">¶</a></h3>
	  <p>Each application has its own PHPUnit configuration, stored in the
	    <tt class="docutils literal"><span class="pre">phpunit.xml.dist</span></tt> file. You can edit this file to change the defaults or
	    create a <tt class="docutils literal"><span class="pre">phpunit.xml</span></tt> file to tweak the configuration for your local machine.</p>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p class="last">Store the <tt class="docutils literal"><span class="pre">phpunit.xml.dist</span></tt> file in your code repository, and ignore the
		<tt class="docutils literal"><span class="pre">phpunit.xml</span></tt> file.</p>
	  </div></div>
	  <p>By default, only the tests stored in "standard" bundles are run by the
	    <tt class="docutils literal"><span class="pre">phpunit</span></tt> command (standard being tests under Vendor\*Bundle\Tests
	    namespaces). But you can easily add more namespaces. For instance, the
	    following configuration adds the tests from the installed third-party bundles:</p>
	  <div class="highlight-xml"><div class="highlight"><pre><span class="c">&lt;!-- hello/phpunit.xml.dist --&gt;</span>
<span class="nt">&lt;testsuites&gt;</span>
    <span class="nt">&lt;testsuite</span> <span class="na">name=</span><span class="s">"Project Test Suite"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;directory&gt;</span>../src/*/*Bundle/Tests<span class="nt">&lt;/directory&gt;</span>
        <span class="nt">&lt;directory&gt;</span>../src/Acme/Bundle/*Bundle/Tests<span class="nt">&lt;/directory&gt;</span>
    <span class="nt">&lt;/testsuite&gt;</span>
<span class="nt">&lt;/testsuites&gt;</span>
	    </pre></div>
	  </div>
	  <p>To include other namespaces in the code coverage, also edit the <tt class="docutils literal"><span class="pre">&lt;filter&gt;</span></tt>
	    section:</p>
	  <div class="highlight-xml"><div class="highlight"><pre><span class="nt">&lt;filter&gt;</span>
    <span class="nt">&lt;whitelist&gt;</span>
        <span class="nt">&lt;directory&gt;</span>../src<span class="nt">&lt;/directory&gt;</span>
        <span class="nt">&lt;exclude&gt;</span>
            <span class="nt">&lt;directory&gt;</span>../src/*/*Bundle/Resources<span class="nt">&lt;/directory&gt;</span>
            <span class="nt">&lt;directory&gt;</span>../src/*/*Bundle/Tests<span class="nt">&lt;/directory&gt;</span>
            <span class="nt">&lt;directory&gt;</span>../src/Acme/Bundle/*Bundle/Resources<span class="nt">&lt;/directory&gt;</span>
            <span class="nt">&lt;directory&gt;</span>../src/Acme/Bundle/*Bundle/Tests<span class="nt">&lt;/directory&gt;</span>
        <span class="nt">&lt;/exclude&gt;</span>
    <span class="nt">&lt;/whitelist&gt;</span>
<span class="nt">&lt;/filter&gt;</span>
	    </pre></div>
	  </div>
	</div>
	<div class="section" id="client-configuration">
	  <h3>Client Configuration<a class="headerlink" href="#client-configuration" title="Permalink to this headline">¶</a></h3>
	  <p>The Client used by functional tests creates a Kernel that runs in a special
	    <tt class="docutils literal"><span class="pre">test</span></tt> environment, so you can tweak it as much as you want:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 382px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><pre># app/config/config_test.yml
imports:
    - { resource: config_dev.yml }

framework:
    error_handler: false
    test: ~

web_profiler:
    toolbar: false
    intercept_redirects: false

monolog:
    handlers:
        main:
            type:  stream
            path:  %kernel.logs_dir%/%kernel.environment%.log
		    level: debug</pre>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/config_test.xml --&gt;</span>
<span class="nt">&lt;container&gt;</span>
    <span class="nt">&lt;imports&gt;</span>
        <span class="nt">&lt;import</span> <span class="na">resource=</span><span class="s">"config_dev.xml"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;/imports&gt;</span>

    <span class="nt">&lt;webprofiler:config</span>
        <span class="na">toolbar=</span><span class="s">"false"</span>
        <span class="na">intercept-redirects=</span><span class="s">"false"</span>
    <span class="nt">/&gt;</span>

    <span class="nt">&lt;framework:config</span> <span class="na">error_handler=</span><span class="s">"false"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;framework:test</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;/framework:config&gt;</span>

    <span class="nt">&lt;monolog:config&gt;</span>
        <span class="nt">&lt;monolog:main</span>
            <span class="na">type=</span><span class="s">"stream"</span>
            <span class="na">path=</span><span class="s">"%kernel.logs_dir%/%kernel.environment%.log"</span>
            <span class="na">level=</span><span class="s">"debug"</span>
         <span class="nt">/&gt;</span>
    <span class="nt">&lt;/monolog:config&gt;</span>
<span class="nt">&lt;/container&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/config_test.php</span>
<span class="nv">$loader</span><span class="o">-&gt;</span><span class="na">import</span><span class="p">(</span><span class="s1">'config_dev.php'</span><span class="p">);</span>

<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'framework'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'error_handler'</span> <span class="o">=&gt;</span> <span class="k">false</span><span class="p">,</span>
    <span class="s1">'test'</span>          <span class="o">=&gt;</span> <span class="k">true</span><span class="p">,</span>
<span class="p">));</span>

<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'web_profiler'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'toolbar'</span> <span class="o">=&gt;</span> <span class="k">false</span><span class="p">,</span>
    <span class="s1">'intercept-redirects'</span> <span class="o">=&gt;</span> <span class="k">false</span><span class="p">,</span>
<span class="p">));</span>

<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'monolog'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'handlers'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'main'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'type'</span> <span class="o">=&gt;</span> <span class="s1">'stream'</span><span class="p">,</span>
                        <span class="s1">'path'</span> <span class="o">=&gt;</span> <span class="s1">'%kernel.logs_dir%/%kernel.environment%.log'</span>
                        <span class="s1">'level'</span> <span class="o">=&gt;</span> <span class="s1">'debug'</span><span class="p">)</span>

<span class="p">)));</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>You can also change the default environment (<tt class="docutils literal"><span class="pre">test</span></tt>) and override the
	    default debug mode (<tt class="docutils literal"><span class="pre">true</span></tt>) by passing them as options to the
	    <tt class="docutils literal"><span class="pre">createClient()</span></tt> method:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$client</span> <span class="o">=</span> <span class="nv">static</span><span class="o">::</span><span class="na">createClient</span><span class="p">(</span><span class="k">array</span><span class="p">(</span>
    <span class="s1">'environment'</span> <span class="o">=&gt;</span> <span class="s1">'my_test_env'</span><span class="p">,</span>
    <span class="s1">'debug'</span>       <span class="o">=&gt;</span> <span class="k">false</span><span class="p">,</span>
<span class="p">));</span>
	    </pre></div>
	  </div>
	  <p>If your application behaves according to some HTTP headers, pass them as the
	    second argument of <tt class="docutils literal"><span class="pre">createClient()</span></tt>:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$client</span> <span class="o">=</span> <span class="nv">static</span><span class="o">::</span><span class="na">createClient</span><span class="p">(</span><span class="k">array</span><span class="p">(),</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'HTTP_HOST'</span>       <span class="o">=&gt;</span> <span class="s1">'en.example.com'</span><span class="p">,</span>
    <span class="s1">'HTTP_USER_AGENT'</span> <span class="o">=&gt;</span> <span class="s1">'MySuperBrowser/1.0'</span><span class="p">,</span>
<span class="p">));</span>
	    </pre></div>
	  </div>
	  <p>You can also override HTTP headers on a per request basis:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$client</span><span class="o">-&gt;</span><span class="na">request</span><span class="p">(</span><span class="s1">'GET'</span><span class="p">,</span> <span class="s1">'/'</span><span class="p">,</span> <span class="k">array</span><span class="p">(),</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'HTTP_HOST'</span>       <span class="o">=&gt;</span> <span class="s1">'en.example.com'</span><span class="p">,</span>
    <span class="s1">'HTTP_USER_AGENT'</span> <span class="o">=&gt;</span> <span class="s1">'MySuperBrowser/1.0'</span><span class="p">,</span>
<span class="p">));</span>
	    </pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p class="last">To provide your own Client, override the <tt class="docutils literal"><span class="pre">test.client.class</span></tt> parameter,
		or define a <tt class="docutils literal"><span class="pre">test.client</span></tt> service.</p>
	  </div></div>
	</div>
      </div>
      <div class="section" id="learn-more-from-the-cookbook">
	<h2>Learn more from the Cookbook<a class="headerlink" href="#learn-more-from-the-cookbook" title="Permalink to this headline">¶</a></h2>
	<ul class="simple">
	  <li><a class="reference internal" href="../cookbook/testing/http_authentication.html"><em>How to simulate HTTP Authentication in a Functional Test</em></a></li>
	  <li><a class="reference internal" href="../cookbook/testing/insulating_clients.html"><em>How to test the Interaction of several Clients</em></a></li>
	  <li><a class="reference internal" href="../cookbook/testing/profiling.html"><em>How to use the Profiler in a Functional Test</em></a></li>
	</ul>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="Databases and Doctrine (&quot;The Model&quot;)" href="doctrine.html">
      «&nbsp;Databases and Doctrine ("The Model")
    </a><span class="separator">|</span>
    <a accesskey="N" title="Validation" href="validation.html">
      Validation&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
