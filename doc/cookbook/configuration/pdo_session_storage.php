<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">How to use PdoSessionStorage to store Sessions in the Database</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="how-to-use-pdosessionstorage-to-store-sessions-in-the-database">
      <span id="index-0"></span><h1>How to use PdoSessionStorage to store Sessions in the Database<a class="headerlink" href="#how-to-use-pdosessionstorage-to-store-sessions-in-the-database" title="Permalink to this headline">¶</a></h1>
      <p>The default session storage of Symfony2 writes the session information to
	file(s). Most medium to large websites use a database to store the session
	values instead of files, because databases are easier to use and scale in a
	multi-webserver environment.</p>
      <p>Symfony2 has a built-in solution for database session storage called
	<tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpFoundation/SessionStorage/PdoSessionStorage.html" title="Symfony\Component\HttpFoundation\SessionStorage\PdoSessionStorage"><span class="pre">PdoSessionStorage</span></a></tt>.
	To use it, you just need to change some parameters in <tt class="docutils literal"><span class="pre">config.yml</span></tt> (or the
	configuration format of your choice):</p>
      <div class="configuration-block jsactive clearfix">
	<ul class="simple" style="height: 490px; ">
	  <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><pre># app/config/config.yml
framework:
    session:
        # ...
        storage_id:     session.storage.pdo

parameters:
    pdo.db_options:
        db_table:    session
        db_id_col:   session_id
        db_data_col: session_value
        db_time_col: session_time

services:
    session.storage.pdo:
        class:     Symfony\Component\HttpFoundation\SessionStorage\PdoSessionStorage
        arguments: [@pdo, %session.storage.options%, %pdo.db_options%]

    pdo:
        class: PDO
        arguments:
            dsn:      "mysql:dbname=mydatabase"
            user:     myuser
		password: mypassword</pre>
	    </div>
	  </li>
	  <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/config.xml --&gt;</span>
<span class="nt">&lt;framework:config&gt;</span>
    <span class="nt">&lt;framework:session</span> <span class="na">storage-id=</span><span class="s">"session.storage.pdo"</span> <span class="na">default-locale=</span><span class="s">"en"</span> <span class="na">lifetime=</span><span class="s">"3600"</span> <span class="na">auto-start=</span><span class="s">"true"</span><span class="nt">/&gt;</span>
<span class="nt">&lt;/framework:config&gt;</span>

<span class="nt">&lt;parameters&gt;</span>
    <span class="nt">&lt;parameter</span> <span class="na">key=</span><span class="s">"pdo.db_options"</span> <span class="na">type=</span><span class="s">"collection"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;parameter</span> <span class="na">key=</span><span class="s">"db_table"</span><span class="nt">&gt;</span>session<span class="nt">&lt;/parameter&gt;</span>
        <span class="nt">&lt;parameter</span> <span class="na">key=</span><span class="s">"db_id_col"</span><span class="nt">&gt;</span>session_id<span class="nt">&lt;/parameter&gt;</span>
        <span class="nt">&lt;parameter</span> <span class="na">key=</span><span class="s">"db_data_col"</span><span class="nt">&gt;</span>session_value<span class="nt">&lt;/parameter&gt;</span>
        <span class="nt">&lt;parameter</span> <span class="na">key=</span><span class="s">"db_time_col"</span><span class="nt">&gt;</span>session_time<span class="nt">&lt;/parameter&gt;</span>
    <span class="nt">&lt;/parameter&gt;</span>
    <span class="nt">&lt;parameter</span> <span class="na">key=</span><span class="s">"pdo.options"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/parameters&gt;</span>

<span class="nt">&lt;services&gt;</span>
    <span class="nt">&lt;service</span> <span class="na">id=</span><span class="s">"pdo"</span> <span class="na">class=</span><span class="s">"PDO"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;argument</span> <span class="na">id=</span><span class="s">"dsn"</span><span class="nt">&gt;</span>mysql:dbname=sf2demo<span class="nt">&lt;/argument&gt;</span>
        <span class="nt">&lt;argument</span> <span class="na">id=</span><span class="s">"user"</span><span class="nt">&gt;</span>root<span class="nt">&lt;/argument&gt;</span>
        <span class="nt">&lt;argument</span> <span class="na">id=</span><span class="s">"password"</span><span class="nt">&gt;</span>password<span class="nt">&lt;/argument&gt;</span>
    <span class="nt">&lt;/service&gt;</span>

    <span class="nt">&lt;service</span> <span class="na">id=</span><span class="s">"session.storage.pdo"</span> <span class="na">class=</span><span class="s">"Symfony\Component\HttpFoundation\SessionStorage\PdoSessionStorage"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;argument</span> <span class="na">type=</span><span class="s">"service"</span> <span class="na">id=</span><span class="s">"pdo"</span> <span class="nt">/&gt;</span>
        <span class="nt">&lt;argument&gt;</span>%pdo.db_options%<span class="nt">&lt;/argument&gt;</span>
        <span class="nt">&lt;argument&gt;</span>%pdo.options%<span class="nt">&lt;/argument&gt;</span>
    <span class="nt">&lt;/service&gt;</span>
<span class="nt">&lt;/services&gt;</span>
	      </pre></div>
	    </div>
	  </li>
	</ul>
      </div>
      <ul class="simple">
	<li><tt class="docutils literal"><span class="pre">db_table</span></tt>: The name of the session table in your database</li>
	<li><tt class="docutils literal"><span class="pre">db_id_col</span></tt>: The name of the id column in your session table (VARCHAR(255) or larger)</li>
	<li><tt class="docutils literal"><span class="pre">db_data_col</span></tt>: The name of the value column in your session table (TEXT or CLOB)</li>
	<li><tt class="docutils literal"><span class="pre">db_time_col</span></tt>: The name of the time column in your session table (INTEGER)</li>
      </ul>
      <div class="section" id="sharing-your-database-connection-information">
	<h2>Sharing your Database Connection Information<a class="headerlink" href="#sharing-your-database-connection-information" title="Permalink to this headline">¶</a></h2>
	<p>With the given configuration, the database connection settings are defined for
	  the session storage connection only. This is OK when you use a separate
	  database for the session data.</p>
	<p>But if you'd like to store the session data in the same database as the rest
	  of your project's data, you can use the connection settings from the
	  parameter.ini by referencing the database-related parameters defined there:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 166px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><pre>pdo:
    class: PDO
    arguments:
        dsn:      "mysql:dbname=%database_name%"
        user:     %database_user%
		  password: %database_password%</pre>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nt">&lt;service</span> <span class="na">id=</span><span class="s">"pdo"</span> <span class="na">class=</span><span class="s">"PDO"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;argument</span> <span class="na">id=</span><span class="s">"dsn"</span><span class="nt">&gt;</span>mysql:dbname=%database_name%<span class="nt">&lt;/argument&gt;</span>
    <span class="nt">&lt;argument</span> <span class="na">id=</span><span class="s">"user"</span><span class="nt">&gt;</span>%database_user%<span class="nt">&lt;/argument&gt;</span>
    <span class="nt">&lt;argument</span> <span class="na">id=</span><span class="s">"password"</span><span class="nt">&gt;</span>%database_password%<span class="nt">&lt;/argument&gt;</span>
<span class="nt">&lt;/service&gt;</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
      </div>
      <div class="section" id="example-mysql-statement">
	<h2>Example MySQL Statement<a class="headerlink" href="#example-mysql-statement" title="Permalink to this headline">¶</a></h2>
	<p>The SQL-Statement for creating the needed Database-Table could look like the
	  following (MySQL):</p>
	<div class="highlight-sql"><div class="highlight"><pre><span class="k">CREATE</span> <span class="k">TABLE</span> <span class="o">`</span><span class="k">session</span><span class="o">`</span> <span class="p">(</span>
    <span class="o">`</span><span class="n">session_id</span><span class="o">`</span> <span class="nb">varchar</span><span class="p">(</span><span class="mi">255</span><span class="p">)</span> <span class="k">NOT</span> <span class="k">NULL</span><span class="p">,</span>
    <span class="o">`</span><span class="n">session_value</span><span class="o">`</span> <span class="nb">text</span> <span class="k">NOT</span> <span class="k">NULL</span><span class="p">,</span>
    <span class="o">`</span><span class="n">session_time</span><span class="o">`</span> <span class="nb">int</span><span class="p">(</span><span class="mi">11</span><span class="p">)</span> <span class="k">NOT</span> <span class="k">NULL</span><span class="p">,</span>
    <span class="k">PRIMARY</span> <span class="k">KEY</span> <span class="p">(</span><span class="o">`</span><span class="n">session_id</span><span class="o">`</span><span class="p">),</span>
    <span class="k">UNIQUE</span> <span class="k">KEY</span> <span class="o">`</span><span class="n">session_id_idx</span><span class="o">`</span> <span class="p">(</span><span class="o">`</span><span class="n">session_id</span><span class="o">`</span><span class="p">)</span>
<span class="p">)</span> <span class="n">ENGINE</span><span class="o">=</span><span class="n">InnoDB</span> <span class="k">DEFAULT</span> <span class="n">CHARSET</span><span class="o">=</span><span class="n">utf8</span><span class="p">;</span>
	  </pre></div>
	</div>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="How to Manage Common Dependencies with Parent Services" href="../service_container/parentservices.html">
      «&nbsp;How to Manage Common Dependencies with Parent Services
    </a><span class="separator">|</span>
    <a accesskey="N" title="How to expose a Semantic Configuration for a Bundle" href="../bundles/extension.html">
      How to expose a Semantic Configuration for a Bundle&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
