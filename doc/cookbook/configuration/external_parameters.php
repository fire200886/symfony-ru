<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">How to Set External Parameters in the Service Container</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="how-to-set-external-parameters-in-the-service-container">
      <span id="index-0"></span><h1>How to Set External Parameters in the Service Container<a class="headerlink" href="#how-to-set-external-parameters-in-the-service-container" title="Permalink to this headline">¶</a></h1>
      <p>In the chapter <a class="reference internal" href="environments.html"><em>How to Master and Create new Environments</em></a>, you learned how
	to manage your application configuration. At times, it may benefit your application
	to store certain credentials outside of your project code. Database configuration
	is one such example. The flexibility of the symfony service container allows
	you to easily do this.</p>
      <div class="section" id="environment-variables">
	<h2>Environment Variables<a class="headerlink" href="#environment-variables" title="Permalink to this headline">¶</a></h2>
	<p>Symfony will grab any environment variable prefixed with <tt class="docutils literal"><span class="pre">SYMFONY__</span></tt> and
	  set it as a parameter in the service container.  Double underscores are replaced
	  with a period, as a period is not a valid character in an environment variable
	  name.</p>
	<p>For example, if you're using Apache, environment variables can be set using
	  the following <tt class="docutils literal"><span class="pre">VirtualHost</span></tt> configuration:</p>
	<div class="highlight-apache"><div class="highlight"><pre><span class="nt">&lt;VirtualHost</span> <span class="s">*:80</span><span class="nt">&gt;</span>
    <span class="nb">ServerName</span>      Symfony2
    <span class="nb">DocumentRoot</span>    <span class="s2">"/path/to/symfony_2_app/web"</span>
    <span class="nb">DirectoryIndex</span>  index.php index.html
    <span class="nb">SetEnv</span>          SYMFONY__DATABASE__USER <span class="k">user</span>
    <span class="nb">SetEnv</span>          SYMFONY__DATABASE__PASSWORD secret

    <span class="nt">&lt;Directory</span> <span class="s">"/path/to/my_symfony_2_app/web"</span><span class="nt">&gt;</span>
        <span class="nb">AllowOverride</span> <span class="k">All</span>
        <span class="nb">Allow</span> from <span class="k">All</span>
    <span class="nt">&lt;/Directory&gt;</span>
<span class="nt">&lt;/VirtualHost&gt;</span>
	  </pre></div>
	</div>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">The example above is for an Apache configuration, using the <a class="reference external" href="http://httpd.apache.org/docs/current/env.html">SetEnv</a>
	      directive.  However, this will work for any web server which supports
	      the setting of environment variables.</p>
	</div></div>
	<p>Now that you have declared an environment variable, it will be present
	  in the PHP <tt class="docutils literal"><span class="pre">$_SERVER</span></tt> global variable. Symfony then automatically sets all
	  <tt class="docutils literal"><span class="pre">$_SERVER</span></tt> variables prefixed with <tt class="docutils literal"><span class="pre">SYMFONY__</span></tt> as parameters in the service
	  container.</p>
	<p>You can now reference these parameters wherever you need them.</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 166px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><pre>doctrine:
    dbal:
        driver    pdo_mysql
        dbname:   symfony2_project
        user:     %database.user%
		  password: %database.password%</pre>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- xmlns:doctrine="http://symfony.com/schema/dic/doctrine" --&gt;</span>
<span class="c">&lt;!-- xsi:schemaLocation="http://symfony.com/schema/dic/doctrine http://symfony.com/schema/dic/doctrine/doctrine-1.0.xsd"&gt; --&gt;</span>

<span class="nt">&lt;doctrine:config&gt;</span>
    <span class="nt">&lt;doctrine:dbal</span>
        <span class="na">driver=</span><span class="s">"pdo_mysql"</span>
        <span class="na">dbname=</span><span class="s">"symfony2_projet"</span>
        <span class="na">user=</span><span class="s">"%database.user%"</span>
        <span class="na">password=</span><span class="s">"%database.password%"</span>
    <span class="nt">/&gt;</span>
<span class="nt">&lt;/doctrine:config&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'doctrine'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'dbal'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'driver'</span>   <span class="o">=&gt;</span> <span class="s1">'pdo_mysql'</span><span class="p">,</span>
    <span class="s1">'dbname'</span>   <span class="o">=&gt;</span> <span class="s1">'symfony2_project'</span><span class="p">,</span>
    <span class="s1">'user'</span>     <span class="o">=&gt;</span> <span class="s1">'%database.user%'</span><span class="p">,</span>
    <span class="s1">'password'</span> <span class="o">=&gt;</span> <span class="s1">'%database.password%'</span><span class="p">,</span>
<span class="p">));</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
      </div>
      <div class="section" id="constants">
	<h2>Constants<a class="headerlink" href="#constants" title="Permalink to this headline">¶</a></h2>
	<p>The container also has support for setting PHP constants as parameters. To
	  take advantage of this feature, map the name of your constant  to a parameter
	  key, and define the type as <tt class="docutils literal"><span class="pre">constant</span></tt>.</p>
	<blockquote>
	  <div><div class="highlight-xml"><div class="highlight"><pre><span class="cp">&lt;?xml version="1.0" encoding="UTF-8"?&gt;</span>

<span class="nt">&lt;container</span> <span class="na">xmlns=</span><span class="s">"http://symfony.com/schema/dic/services"</span>
    <span class="na">xmlns:xsi=</span><span class="s">"http://www.w3.org/2001/XMLSchema-instance"</span>
<span class="nt">&gt;</span>

    <span class="nt">&lt;parameters&gt;</span>
        <span class="nt">&lt;parameter</span> <span class="na">key=</span><span class="s">"global.constant.value"</span> <span class="na">type=</span><span class="s">"constant"</span><span class="nt">&gt;</span>GLOBAL_CONSTANT<span class="nt">&lt;/parameter&gt;</span>
        <span class="nt">&lt;parameter</span> <span class="na">key=</span><span class="s">"my_class.constant.value"</span> <span class="na">type=</span><span class="s">"constant"</span><span class="nt">&gt;</span>My_Class::CONSTANT_NAME<span class="nt">&lt;/parameter&gt;</span>
    <span class="nt">&lt;/parameters&gt;</span>
<span class="nt">&lt;/container&gt;</span>
	      </pre></div>
	    </div>
	</div></blockquote>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p>This only works for XML configuration. If you're <em>not</em> using XML, simply
	      import an XML file to take advantage of this functionality:</p>
	    <div class="last highlight-yaml"><div class="highlight"><pre><span class="l-Scalar-Plain">// app/config/config.yml</span>
<span class="l-Scalar-Plain">imports</span><span class="p-Indicator">:</span>
    <span class="p-Indicator">-</span> <span class="p-Indicator">{</span> <span class="nv">resource</span><span class="p-Indicator">:</span> <span class="nv">parameters.xml</span> <span class="p-Indicator">}</span>
	      </pre></div>
	    </div>
	</div></div>
      </div>
      <div class="section" id="miscellaneous-configuration">
	<h2>Miscellaneous Configuration<a class="headerlink" href="#miscellaneous-configuration" title="Permalink to this headline">¶</a></h2>
	<p>The <tt class="docutils literal"><span class="pre">imports</span></tt> directive can be used to pull in parameters stored elsewhere.
	  Importing a PHP file gives you the flexibility to add whatever is needed
	  in the container. The following imports a file named <tt class="docutils literal"><span class="pre">parameters.php</span></tt>.</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 112px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/config.yml</span>
<span class="l-Scalar-Plain">imports</span><span class="p-Indicator">:</span>
    <span class="p-Indicator">-</span> <span class="p-Indicator">{</span> <span class="nv">resource</span><span class="p-Indicator">:</span> <span class="nv">parameters.php</span> <span class="p-Indicator">}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/config.xml --&gt;</span>
<span class="nt">&lt;imports&gt;</span>
    <span class="nt">&lt;import</span> <span class="na">resource=</span><span class="s">"parameters.php"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/imports&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/config.php</span>
<span class="nv">$loader</span><span class="o">-&gt;</span><span class="na">import</span><span class="p">(</span><span class="s1">'parameters.php'</span><span class="p">);</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">A resource file can be one of many types. PHP, XML, YAML, INI, and
	      closure resources are all supported by the <tt class="docutils literal"><span class="pre">imports</span></tt> directive.</p>
	</div></div>
	<p>In <tt class="docutils literal"><span class="pre">parameters.php</span></tt>, tell the service container the parameters that you wish
	  to set. This is useful when important configuration is in a nonstandard
	  format. The example below includes a Drupal database's configuration in
	  the symfony service container.</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// app/config/parameters.php</span>

<span class="k">include_once</span><span class="p">(</span><span class="s1">'/path/to/drupal/sites/all/default/settings.php'</span><span class="p">);</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">setParameter</span><span class="p">(</span><span class="s1">'drupal.database.url'</span><span class="p">,</span> <span class="nv">$db_url</span><span class="p">);</span>
	  </pre></div>
	</div>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="How to Master and Create new Environments" href="environments.html">
      «&nbsp;How to Master and Create new Environments
    </a><span class="separator">|</span>
    <a accesskey="N" title="How to Use a Factory to Create Services" href="../service_container/factories.html">
      How to Use a Factory to Create Services&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
