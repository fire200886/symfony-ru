<?php include(__DIR__.'/../_doc.php')?>
<div class="column_02">
  <div class="box_title">
    <h1 class="title_01">Bundles</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="bundles">
      <span id="index-0"></span><h1>Bundles<a class="headerlink" href="#bundles" title="Permalink to this headline">¶</a></h1>
      <p>A bundle is a directory that has a well-defined structure and can host anything
	from classes to controllers and web resources. Even if bundles are very
	flexible, you should follow some best practices if you want to distribute them.</p>
      <div class="section" id="bundle-name">
	<span id="bundles-naming-conventions"></span><span id="index-1"></span><h2>Bundle Name<a class="headerlink" href="#bundle-name" title="Permalink to this headline">¶</a></h2>
	<p>A bundle is also a PHP namespace. The namespace must follow the technical
	  interoperability <a class="reference external" href="http://groups.google.com/group/php-standards/web/psr-0-final-proposal">standards</a> for PHP 5.3 namespaces and class names: it
	  starts with a vendor segment, followed by zero or more category segments, and
	  it ends with the namespace short name, which must end with a <tt class="docutils literal"><span class="pre">Bundle</span></tt>
	  suffix.</p>
	<p>A namespace becomes a bundle as soon as you add a bundle class to it. The
	  bundle class name must follow these simple rules:</p>
	<ul class="simple">
	  <li>Use only alphanumeric characters and underscores;</li>
	  <li>Use a CamelCased name;</li>
	  <li>Use a descriptive and short name (no more than 2 words);</li>
	  <li>Prefix the name with the concatenation of the vendor (and optionally the
	    category namespaces);</li>
	  <li>Suffix the name with <tt class="docutils literal"><span class="pre">Bundle</span></tt>.</li>
	</ul>
	<p>Here are some valid bundle namespaces and class names:</p>
	<table border="1" class="docutils">
	  <colgroup>
	    <col width="57%">
	    <col width="43%">
	  </colgroup>
	  <thead valign="bottom">
	    <tr><th class="head">Namespace</th>
	      <th class="head">Bundle Class Name</th>
	    </tr>
	  </thead>
	  <tbody valign="top">
	    <tr><td><tt class="docutils literal"><span class="pre">Acme\Bundle\BlogBundle</span></tt></td>
	      <td><tt class="docutils literal"><span class="pre">AcmeBlogBundle</span></tt></td>
	    </tr>
	    <tr><td><tt class="docutils literal"><span class="pre">Acme\Bundle\Social\BlogBundle</span></tt></td>
	      <td><tt class="docutils literal"><span class="pre">AcmeSocialBlogBundle</span></tt></td>
	    </tr>
	    <tr><td><tt class="docutils literal"><span class="pre">Acme\BlogBundle</span></tt></td>
	      <td><tt class="docutils literal"><span class="pre">AcmeBlogBundle</span></tt></td>
	    </tr>
	  </tbody>
	</table>
	<p>By convention, the <tt class="docutils literal"><span class="pre">getName()</span></tt> method of the bundle class should return the
	  class name.</p>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">If you share your bundle publicly, you must use the bundle class name as
	      the name of the repository (<tt class="docutils literal"><span class="pre">AcmeBlogBundle</span></tt> and not <tt class="docutils literal"><span class="pre">BlogBundle</span></tt>
	      for instance).</p>
	</div></div>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">Symfony2 core Bundles do not prefix the Bundle class with <tt class="docutils literal"><span class="pre">Symfony</span></tt>
	      and always add a <tt class="docutils literal"><span class="pre">Bundle</span></tt> subnamespace; for example:
	      <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Bundle/FrameworkBundle/FrameworkBundle.html" title="Symfony\Bundle\FrameworkBundle\FrameworkBundle"><span class="pre">FrameworkBundle</span></a></tt>.</p>
	</div></div>
      </div>
      <div class="section" id="directory-structure">
	<h2>Directory Structure<a class="headerlink" href="#directory-structure" title="Permalink to this headline">¶</a></h2>
	<p>The basic directory structure of a <tt class="docutils literal"><span class="pre">HelloBundle</span></tt> bundle must read as
	  follows:</p>
	<div class="highlight-text"><div class="highlight"><pre>XXX/...
    HelloBundle/
        HelloBundle.php
        Controller/
        Resources/
            meta/
                LICENSE
            config/
            doc/
                index.rst
            translations/
            views/
            public/
        Tests/
	  </pre></div>
	</div>
	<p>The <tt class="docutils literal"><span class="pre">XXX</span></tt> directory(ies) reflects the namespace structure of the bundle.</p>
	<p>The following files are mandatory:</p>
	<ul class="simple">
	  <li><tt class="docutils literal"><span class="pre">HelloBundle.php</span></tt>;</li>
	  <li><tt class="docutils literal"><span class="pre">Resources/meta/LICENSE</span></tt>: The full license for the code;</li>
	  <li><tt class="docutils literal"><span class="pre">Resources/doc/index.rst</span></tt>: The root file for the Bundle documentation.</li>
	</ul>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">These conventions ensure that automated tools can rely on this default
	      structure to work.</p>
	</div></div>
	<p>The depth of sub-directories should be kept to the minimal for most used
	  classes and files (2 levels at a maximum). More levels can be defined for
	  non-strategic, less-used files.</p>
	<p>The bundle directory is read-only. If you need to write temporary files, store
	  them under the <tt class="docutils literal"><span class="pre">cache/</span></tt> or <tt class="docutils literal"><span class="pre">log/</span></tt> directory of the host application. Tools
	  can generate files in the bundle directory structure, but only if the generated
	  files are going to be part of the repository.</p>
	<p>The following classes and files have specific emplacements:</p>
	<table border="1" class="docutils">
	  <colgroup>
	    <col width="48%">
	    <col width="52%">
	  </colgroup>
	  <thead valign="bottom">
	    <tr><th class="head">Type</th>
	      <th class="head">Directory</th>
	    </tr>
	  </thead>
	  <tbody valign="top">
	    <tr><td>Controllers</td>
	      <td><tt class="docutils literal"><span class="pre">Controller/</span></tt></td>
	    </tr>
	    <tr><td>Translation files</td>
	      <td><tt class="docutils literal"><span class="pre">Resources/translations/</span></tt></td>
	    </tr>
	    <tr><td>Templates</td>
	      <td><tt class="docutils literal"><span class="pre">Resources/views/</span></tt></td>
	    </tr>
	    <tr><td>Unit and Functional Tests</td>
	      <td><tt class="docutils literal"><span class="pre">Tests/</span></tt></td>
	    </tr>
	    <tr><td>Web Resources</td>
	      <td><tt class="docutils literal"><span class="pre">Resources/public/</span></tt></td>
	    </tr>
	    <tr><td>Configuration</td>
	      <td><tt class="docutils literal"><span class="pre">Resources/config/</span></tt></td>
	    </tr>
	    <tr><td>Commands</td>
	      <td><tt class="docutils literal"><span class="pre">Command/</span></tt></td>
	    </tr>
	  </tbody>
	</table>
      </div>
      <div class="section" id="classes">
	<h2>Classes<a class="headerlink" href="#classes" title="Permalink to this headline">¶</a></h2>
	<p>The bundle directory structure is used as the namespace hierarchy. For
	  instance, a <tt class="docutils literal"><span class="pre">HelloController</span></tt> controller is stored in
	  <tt class="docutils literal"><span class="pre">Bundle/HelloBundle/Controller/HelloController.php</span></tt> and the fully qualified
	  class name is <tt class="docutils literal"><span class="pre">Bundle\HelloBundle\Controller\HelloController</span></tt>.</p>
	<p>All classes and files must follow the Symfony2 coding <a class="reference internal" href="../contributing/code/standards.html"><em>standards</em></a>.</p>
	<p>Some classes should be seen as facades and should be as short as possible, like
	  Commands, Helpers, Listeners, and Controllers.</p>
	<p>Classes that connects to the Event Dispatcher should be suffixed with
	  <tt class="docutils literal"><span class="pre">Listener</span></tt>.</p>
	<p>Exceptions classes should be stored in an <tt class="docutils literal"><span class="pre">Exception</span></tt> sub-namespace.</p>
      </div>
      <div class="section" id="vendors">
	<h2>Vendors<a class="headerlink" href="#vendors" title="Permalink to this headline">¶</a></h2>
	<p>A bundle must not embed third-party PHP libraries. It should rely on the
	  standard Symfony2 autoloading instead.</p>
	<p>A bundle should not embed third-party libraries written in JavaScript, CSS, or
	  any other language.</p>
      </div>
      <div class="section" id="tests">
	<h2>Tests<a class="headerlink" href="#tests" title="Permalink to this headline">¶</a></h2>
	<p>A bundle should come with a test suite written with PHPUnit and stored under
	  the <tt class="docutils literal"><span class="pre">Tests/</span></tt> directory. Tests should follow the following principles:</p>
	<ul class="simple">
	  <li>The test suite must be executable with a simple <tt class="docutils literal"><span class="pre">phpunit</span></tt> command run from
	    a sample application;</li>
	  <li>The functional tests should only be used to test the response output and
	    some profiling information if you have some;</li>
	  <li>The code coverage should at least covers 95% of the code base.</li>
	</ul>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">A test suite must not contain <tt class="docutils literal"><span class="pre">AllTests.php</span></tt> scripts, but must rely on the
	      existence of a <tt class="docutils literal"><span class="pre">phpunit.xml.dist</span></tt> file.</p>
	</div></div>
      </div>
      <div class="section" id="documentation">
	<h2>Documentation<a class="headerlink" href="#documentation" title="Permalink to this headline">¶</a></h2>
	<p>All classes and functions must come with full PHPDoc.</p>
	<p>Extensive documentation should also be provided in the <a class="reference internal" href="../contributing/documentation/format.html"><em>reStructuredText</em></a> format, under the <tt class="docutils literal"><span class="pre">Resources/doc/</span></tt>
	  directory; the <tt class="docutils literal"><span class="pre">Resources/doc/index.rst</span></tt> file is the only mandatory file.</p>
      </div>
      <div class="section" id="controllers">
	<h2>Controllers<a class="headerlink" href="#controllers" title="Permalink to this headline">¶</a></h2>
	<p>As a best practice, controllers in a bundle that's meant to be distributed
	  to others must not extend the
	  <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Bundle/FrameworkBundle/Controller/Controller.html" title="Symfony\Bundle\FrameworkBundle\Controller\Controller"><span class="pre">Controller</span></a></tt> base class.
	  They can implement
	  <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/DependencyInjection/ContainerAwareInterface.html" title="Symfony\Component\DependencyInjection\ContainerAwareInterface"><span class="pre">ContainerAwareInterface</span></a></tt> or
	  extend <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/DependencyInjection/ContainerAware.html" title="Symfony\Component\DependencyInjection\ContainerAware"><span class="pre">ContainerAware</span></a></tt>
	  instead.</p>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">If you have a look at
	      <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Bundle/FrameworkBundle/Controller/Controller.html" title="Symfony\Bundle\FrameworkBundle\Controller\Controller"><span class="pre">Controller</span></a></tt> methods,
	      you will see that they are only nice shortcuts to ease the learning curve.</p>
	</div></div>
      </div>
      <div class="section" id="templates">
	<h2>Templates<a class="headerlink" href="#templates" title="Permalink to this headline">¶</a></h2>
	<p>If a bundle provides templates, they must use Twig. A bundle must not provide
	  a main layout, except if it provides a full working application.</p>
      </div>
      <div class="section" id="translation-files">
	<h2>Translation Files<a class="headerlink" href="#translation-files" title="Permalink to this headline">¶</a></h2>
	<p>If a bundle provides message translations, they must be defined in the XLIFF
	  format; the domain should be named after the bundle name (<tt class="docutils literal"><span class="pre">bundle.hello</span></tt>).</p>
	<p>A bundle must not override existing messages from another bundle.</p>
      </div>
      <div class="section" id="configuration">
	<h2>Configuration<a class="headerlink" href="#configuration" title="Permalink to this headline">¶</a></h2>
	<p>To provide more flexibility, a bundle can provide configurable settings by
	  using the Symfony2 built-in mechanisms.</p>
	<p>For simple configuration settings, rely on the default <tt class="docutils literal"><span class="pre">parameters</span></tt> entry of
	  the Symfony2 configuration. Symfony2 parameters are simple key/value pairs; a
	  value being any valid PHP value. Each parameter name should start with a
	  lower-cased short version of the bundle name using underscores (<tt class="docutils literal"><span class="pre">acme_hello</span></tt>
	  for <tt class="docutils literal"><span class="pre">AcmeHelloBundle</span></tt>, or <tt class="docutils literal"><span class="pre">acme_social_blog</span></tt> for <tt class="docutils literal"><span class="pre">Acme\Social\BlogBundle</span></tt>
	  for instance), though this is just a best-practice suggestion. The rest of
	  the parameter name will use a period (<tt class="docutils literal"><span class="pre">.</span></tt>) to separate different parts
	  (e.g. <tt class="docutils literal"><span class="pre">acme_hello.email.from</span></tt>).</p>
	<p>The end user can provide values in any configuration file:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 94px; ">
	    <li class=""><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: none; "><div class="highlight"><pre><span class="c1"># app/config/config.yml</span>
<span class="l-Scalar-Plain">parameters</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">acme_hello.email.from</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">fabien@example.com</span>
		</pre></div>
	      </div>
	    </li>
	    <li class=""><em><a href="#">XML</a></em><div class="highlight-xml" style="width: 690px; display: none; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/config.xml --&gt;</span>
<span class="nt">&lt;parameters&gt;</span>
    <span class="nt">&lt;parameter</span> <span class="na">key=</span><span class="s">"acme_hello.email.from"</span><span class="nt">&gt;</span>fabien@example.com<span class="nt">&lt;/parameter&gt;</span>
<span class="nt">&lt;/parameters&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1">// app/config/config.php</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setParameter</span><span class="p">(</span><span class="s1">'acme_hello.email.from'</span><span class="p">,</span> <span class="s1">'fabien@example.com'</span><span class="p">);</span>
		</pre></div>
	      </div>
	    </li>
	    <li class=""><em><a href="#">INI</a></em><div class="highlight-ini" style="width: 690px; display: none; "><div class="highlight"><pre><span class="k">[parameters]</span>
<span class="na">acme_hello.email.from</span> <span class="o">=</span> <span class="s">fabien@example.com</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>Retrieve the configuration parameters in your code from the container:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$container</span><span class="o">-&gt;</span><span class="na">getParameter</span><span class="p">(</span><span class="s1">'acme_hello.email.from'</span><span class="p">);</span>
	  </pre></div>
	</div>
	<p>Even if this mechanism is simple enough, you are highly encouraged to use the
	  semantic configuration described in the cookbook.</p>
      </div>
      <div class="section" id="learn-more-from-the-cookbook">
	<h2>Learn more from the Cookbook<a class="headerlink" href="#learn-more-from-the-cookbook" title="Permalink to this headline">¶</a></h2>
	<ul class="simple">
	  <li><a class="reference internal" href="../cookbook/bundles/extension.html"><em>How to expose a Semantic Configuration for a Bundle</em></a></li>
	</ul>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="Translations" href="translation.html">
      «&nbsp;Translations
    </a><span class="separator">|</span>
    <a accesskey="N" title="The Service Container" href="service_container.html">
      The Service Container&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
