<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">


  <div class="box_title">
    <h1 class="title_01">How to use Doctrine's DBAL Layer</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="how-to-use-doctrine-s-dbal-layer">
      <span id="index-0"></span><h1>How to use Doctrine's DBAL Layer<a class="headerlink" href="#how-to-use-doctrine-s-dbal-layer" title="Permalink to this headline">¶</a></h1>
      <div class="admonition-wrapper">
	<div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	  <p class="last">This article is about Doctrine DBAL's layer. Typically, you'll work with
	    the higher level Doctrine ORM layer, which simply uses the DBAL behind
	    the scenes to actually communicate with the database. To read more about
	    the Doctrine ORM, see "<a class="reference internal" href="../../book/doctrine.html"><em>Databases and Doctrine ("The Model")</em></a>".</p>
      </div></div>
      <p>The <a class="reference external" href="http://www.doctrine-project.org/projects/dbal/2.0/docs/en">Doctrine</a> Database Abstraction Layer (DBAL) is an abstraction layer that
	sits on top of <a class="reference external" href="http://www.php.net/pdo">PDO</a> and offers an intuitive and flexible API for communicating
	with the most popular relational databases. In other words, the DBAL library
	makes it easy to execute queries and perform other database actions.</p>
      <div class="admonition-wrapper">
	<div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	  <p class="last">Read the official Doctrine <a class="reference external" href="http://www.doctrine-project.org/projects/dbal/2.0/docs/en">DBAL Documentation</a> to learn all the details
	    and capabilities of Doctrine's DBAL library.</p>
      </div></div>
      <p>To get started, configure the database connection parameters:</p>
      <div class="configuration-block jsactive clearfix">
	<ul class="simple" style="height: 184px; ">
	  <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/config.yml</span>
<span class="l-Scalar-Plain">doctrine</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">dbal</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">driver</span><span class="p-Indicator">:</span>   <span class="l-Scalar-Plain">pdo_mysql</span>
        <span class="l-Scalar-Plain">dbname</span><span class="p-Indicator">:</span>   <span class="l-Scalar-Plain">Symfony2</span>
        <span class="l-Scalar-Plain">user</span><span class="p-Indicator">:</span>     <span class="l-Scalar-Plain">root</span>
        <span class="l-Scalar-Plain">password</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">null</span>
	      </pre></div>
	    </div>
	  </li>
	  <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre>// app/config/config.xml
<span class="nt">&lt;doctrine:config&gt;</span>
    <span class="nt">&lt;doctrine:dbal</span>
        <span class="na">name=</span><span class="s">"default"</span>
        <span class="na">dbname=</span><span class="s">"Symfony2"</span>
        <span class="na">user=</span><span class="s">"root"</span>
        <span class="na">password=</span><span class="s">"null"</span>
        <span class="na">driver=</span><span class="s">"pdo_mysql"</span>
    <span class="nt">/&gt;</span>
<span class="nt">&lt;/doctrine:config&gt;</span>
	      </pre></div>
	    </div>
	  </li>
	  <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/config.php</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'doctrine'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'dbal'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'driver'</span>    <span class="o">=&gt;</span> <span class="s1">'pdo_mysql'</span><span class="p">,</span>
        <span class="s1">'dbname'</span>    <span class="o">=&gt;</span> <span class="s1">'Symfony2'</span><span class="p">,</span>
        <span class="s1">'user'</span>      <span class="o">=&gt;</span> <span class="s1">'root'</span><span class="p">,</span>
        <span class="s1">'password'</span>  <span class="o">=&gt;</span> <span class="k">null</span><span class="p">,</span>
    <span class="p">),</span>
<span class="p">));</span>
	      </pre></div>
	    </div>
	  </li>
	</ul>
      </div>
      <p>For full DBAL configuration options, see <a class="reference internal" href="../../reference/configuration/doctrine.html#reference-dbal-configuration"><em>Doctrine DBAL Configuration</em></a>.</p>
      <p>You can then access the Doctrine DBAL connection by accessing the
	<tt class="docutils literal"><span class="pre">database_connection</span></tt> service:</p>
      <div class="highlight-php"><div class="highlight"><pre><span class="k">class</span> <span class="nc">UserController</span> <span class="k">extends</span> <span class="nx">Controller</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">indexAction</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="nv">$conn</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'database_connection'</span><span class="p">);</span>
        <span class="nv">$users</span> <span class="o">=</span> <span class="nv">$conn</span><span class="o">-&gt;</span><span class="na">fetchAll</span><span class="p">(</span><span class="s1">'SELECT * FROM users'</span><span class="p">);</span>

        <span class="c1">// ...</span>
    <span class="p">}</span>
<span class="p">}</span>
	</pre></div>
      </div>
      <div class="section" id="registering-custom-mapping-types">
	<h2>Registering Custom Mapping Types<a class="headerlink" href="#registering-custom-mapping-types" title="Permalink to this headline">¶</a></h2>
	<p>You can register custom mapping types through Symfony's configuration. They
	  will be added to all configured connections. For more information on custom
	  mapping types, read Doctrine's <a class="reference external" href="http://www.doctrine-project.org/docs/dbal/2.0/en/reference/types.html#custom-mapping-types">Custom Mapping Types</a> section of their documentation.</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 166px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/config.yml</span>
<span class="l-Scalar-Plain">doctrine</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">dbal</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">types</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">custom_first</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">Acme\HelloBundle\Type\CustomFirst</span>
            <span class="l-Scalar-Plain">custom_second</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">Acme\HelloBundle\Type\CustomSecond</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/config.xml --&gt;</span>
<span class="nt">&lt;container</span> <span class="na">xmlns=</span><span class="s">"http://symfony.com/schema/dic/services"</span>
    <span class="na">xmlns:xsi=</span><span class="s">"http://www.w3.org/2001/XMLSchema-instance"</span>
    <span class="na">xmlns:doctrine=</span><span class="s">"http://symfony.com/schema/dic/doctrine"</span>
    <span class="na">xsi:schemaLocation=</span><span class="s">"http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services-1.0.xsd</span>
<span class="s">                        http://symfony.com/schema/dic/doctrine http://symfony.com/schema/dic/doctrine/doctrine-1.0.xsd"</span><span class="nt">&gt;</span>

    <span class="nt">&lt;doctrine:config&gt;</span>
        <span class="nt">&lt;doctrine:dbal&gt;</span>
            <span class="nt">&lt;doctrine:type</span> <span class="na">name=</span><span class="s">"custom_first"</span> <span class="na">class=</span><span class="s">"Acme\HelloBundle\Type\CustomFirst"</span> <span class="nt">/&gt;</span>
            <span class="nt">&lt;doctrine:type</span> <span class="na">name=</span><span class="s">"custom_second"</span> <span class="na">class=</span><span class="s">"Acme\HelloBundle\Type\CustomSecond"</span> <span class="nt">/&gt;</span>
        <span class="nt">&lt;/doctrine:dbal&gt;</span>
    <span class="nt">&lt;/doctrine:config&gt;</span>
<span class="nt">&lt;/container&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/config.php</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'doctrine'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'dbal'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'types'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
            <span class="s1">'custom_first'</span>  <span class="o">=&gt;</span> <span class="s1">'Acme\HelloBundle\Type\CustomFirst'</span><span class="p">,</span>
            <span class="s1">'custom_second'</span> <span class="o">=&gt;</span> <span class="s1">'Acme\HelloBundle\Type\CustomSecond'</span><span class="p">,</span>
        <span class="p">),</span>
    <span class="p">),</span>
<span class="p">));</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="How to generate Entities from an Existing Database" href="reverse_engineering.html">
      «&nbsp;How to generate Entities from an Existing Database
    </a><span class="separator">|</span>
    <a accesskey="N" title="How to work with Multiple Entity Managers" href="multiple_entity_managers.html">
      How to work with Multiple Entity Managers&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
