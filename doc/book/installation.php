<?php include(__DIR__.'/../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">Установка и кофигурация Symfony</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="installing-and-configuring-symfony">
      <span id="index-0"></span><h1>Installing and Configuring Symfony<a class="headerlink" href="#installing-and-configuring-symfony" title="Permalink to this headline">¶</a></h1>
      <p>The goal of this chapter is to get you up and running with a working application
	built on top of Symfony. Fortunately, Symfony offers "distributions", which
	are functional Symfony "starter" projects that you can download and begin
	developing in immediately.</p>
      <div class="section" id="downloading-a-symfony2-distribution">
	<h2>Downloading a Symfony2 Distribution<a class="headerlink" href="#downloading-a-symfony2-distribution" title="Permalink to this headline">¶</a></h2>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">First, check that you have installed and configured a Web server (such
	      as Apache) with PHP 5.3.2 or higher. For more information on Symfony2
	      requirements, see the <a class="reference internal" href="../reference/requirements.html"><em>requirements reference</em></a>.</p>
	</div></div>
	<p>Symfony2 packages "distributions", which are fully-functional applications
	  that include the Symfony2 core libraries, a selection of useful bundles, a
	  sensible directory structure and some default configuration. When you download
	  a Symfony2 distribution, you're downloading a functional application skeleton
	  that can be used immediately to begin developing your application.</p>
	<p>Start by visiting the Symfony2 download page at <a class="reference external" href="http://symfony.com/download">http://symfony.com/download</a>.
	  On this page, you'll see the <em>Symfony Standard Edition</em>, which is the main
	  Symfony2 distribution. Here, you'll need to make two choices:</p>
	<ul class="simple">
	  <li>Download either a <tt class="docutils literal"><span class="pre">.tgz</span></tt> or <tt class="docutils literal"><span class="pre">.zip</span></tt> archive - both are equivalent, download
	    whatever you're more comfortable using;</li>
	  <li>Download the distribution with or without vendors. If you have <a class="reference external" href="http://git-scm.com/">Git</a> installed
	    on your computer, you should download Symfony2 "without vendors", as it
	    adds a bit more flexibility when including third-party/vendor libraries.</li>
	</ul>
	<p>Download one of the archives somewhere under your local web server's root
	  directory and unpack it. From a UNIX command line, this can be done with
	  one of the following commands (replacing <tt class="docutils literal"><span class="pre">###</span></tt> with your actual filename):</p>
	<div class="highlight-bash"><div class="highlight"><pre><span class="c"># for .tgz file</span>
tar zxvf Symfony_Standard_Vendors_2.0.###.tgz

<span class="c"># for a .zip file</span>
unzip Symfony_Standard_Vendors_2.0.###.tgz
	  </pre></div>
	</div>
	<p>When you're finished, you should have a <tt class="docutils literal"><span class="pre">Symfony/</span></tt> directory that looks
	  something like this:</p>
	<div class="highlight-text"><div class="highlight"><pre>www/ &lt;- your web root directory
    Symfony/ &lt;- the unpacked archive
        app/
            cache/
            config/
            logs/
        src/
            ...
        vendor/
            ...
        web/
            app.php
            ...
	  </pre></div>
	</div>
	<div class="section" id="updating-vendors">
	  <h3>Updating Vendors<a class="headerlink" href="#updating-vendors" title="Permalink to this headline">¶</a></h3>
	  <p>Finally, if you downloaded the archive "without vendors", install the vendors
	    by running the following command from the command line:</p>
	  <div class="highlight-bash"><div class="highlight"><pre>php bin/vendors install
	    </pre></div>
	  </div>
	  <p>This command downloads all of the necessary vendor libraries - including
	    Symfony itself - into the <tt class="docutils literal"><span class="pre">vendor/</span></tt> directory.</p>
	</div>
	<div class="section" id="configuration-and-setup">
	  <h3>Configuration and Setup<a class="headerlink" href="#configuration-and-setup" title="Permalink to this headline">¶</a></h3>
	  <p>At this point, all of the needed third-party libraries now live in the <tt class="docutils literal"><span class="pre">vendor/</span></tt>
	    directory. You also have a default application setup in <tt class="docutils literal"><span class="pre">app/</span></tt> and some
	    sample code inside the <tt class="docutils literal"><span class="pre">src/</span></tt> directory.</p>
	  <p>Symfony2 comes with a visual server configuration tester to help make sure
	    your Web server and PHP are configured to use Symfony. Use the following URL
	    to check your configuration:</p>
	  <div class="highlight-text"><div class="highlight"><pre>http://localhost/Symfony/web/config.php
	    </pre></div>
	  </div>
	  <p>If there are any issues, correct them now before moving on.</p>
	  <div class="admonition-wrapper">
	    <div class="sidebar"></div><div class="admonition admonition-sidebar"><p class="first sidebar-title">Setting up Permissions</p>
	      <p>One common issue is that the <tt class="docutils literal"><span class="pre">app/cache</span></tt> and <tt class="docutils literal"><span class="pre">app/logs</span></tt> directories
		must be writable both by the web server and the command line user. On
		a UNIX system, if your web server user is different from your command
		line user, you can run the following commands just once in your project
		to ensure that permissions will be setup properly. Change <tt class="docutils literal"><span class="pre">www-data</span></tt>
		to the web server user and <tt class="docutils literal"><span class="pre">yourname</span></tt> to your command line user:</p>
	      <p><strong>1. Using ACL on a system that supports chmod +a</strong></p>
	      <div class="highlight-bash"><div class="highlight"><pre>Many systems allow you to use the <span class="sb">``</span>chmod +a<span class="sb">``</span> command. Try this first,
and <span class="k">if </span>you get an error - try the next method:

rm -rf app/cache/*
rm -rf app/logs/*

sudo chmod +a <span class="s2">"www-data allow delete,write,append,file_inherit,directory_inherit"</span> app/cache app/logs
sudo chmod +a <span class="s2">"yourname allow delete,write,append,file_inherit,directory_inherit"</span> app/cache app/logs
		</pre></div>
	      </div>
	      <p><strong>2. Using Acl on a system that does not support chmod +a</strong></p>
	      <p>Some systems, like Ubuntu, don't support <tt class="docutils literal"><span class="pre">chmod</span> <span class="pre">+a</span></tt>, but do support
		another utility called <tt class="docutils literal"><span class="pre">setfacl</span></tt>. On some systems, this will need to
		be installed before using it:</p>
	      <div class="highlight-bash"><div class="highlight"><pre>sudo setfacl -R -m u:www-data:rwx -m u:yourname:rwx app/cache app/logs
sudo setfacl -dR -m u:www-data:rwx -m u:yourname:rwx app/cache app/logs
		</pre></div>
	      </div>
	      <p><strong>3. Without using ACL</strong></p>
	      <p>If you don't have access to changing the ACL of the directories, you will
		need to change the umask so that the cache and log directories will
		be group-writable or world-writable (depending if the web server user
		and the command line user are in the same group or not). To achieve
		this, put the following line at the beginning of the <tt class="docutils literal"><span class="pre">app/console</span></tt>,
		<tt class="docutils literal"><span class="pre">web/app.php</span></tt> and <tt class="docutils literal"><span class="pre">web/app_dev.php</span></tt> files:</p>
	      <div class="highlight-php"><div class="highlight"><pre><span class="nb">umask</span><span class="p">(</span><span class="mo">0002</span><span class="p">);</span> <span class="c1">// This will let the permissions be 0775</span>

<span class="c1">// or</span>

<span class="nb">umask</span><span class="p">(</span><span class="mo">0000</span><span class="p">);</span> <span class="c1">// This will let the permissions be 0777</span>
		</pre></div>
	      </div>
	      <p class="last">Note that using the ACL is recommended when you have access to them
		on your server because changing the umask is not thread-safe.</p>
	  </div></div>
	  <p>When everything is fine, click on "Go to the Welcome page" to request your
	    first "real" Symfony2 webpage:</p>
	  <div class="highlight-text"><div class="highlight"><pre>http://localhost/Symfony/web/app_dev.php/
	    </pre></div>
	  </div>
	  <p>Symfony2 should welcome and congratulate you for your hard work so far!</p>
	  <img alt="../_images/welcome.jpg" src="../_images/welcome.jpg">
	</div>
      </div>
      <div class="section" id="beginning-development">
	<h2>Beginning Development<a class="headerlink" href="#beginning-development" title="Permalink to this headline">¶</a></h2>
	<p>Now that you have a fully-functional Symfony2 application, you can begin
	  development! Your distribution may contain some sample code - check the
	  <tt class="docutils literal"><span class="pre">README.rst</span></tt> file included with the distribution (open it as a text file)
	  to learn about what sample code was included with your distribution and how
	  you can remove it later.</p>
	<p>If you're new to Symfony, join us in the "<a class="reference internal" href="page_creation.html"><em>Creating Pages in Symfony2</em></a>", where you'll
	  learn how to create pages, change configuration, and do everything else you'll
	  need in your new application.</p>
      </div>
      <div class="section" id="using-source-control">
	<h2>Using Source Control<a class="headerlink" href="#using-source-control" title="Permalink to this headline">¶</a></h2>
	<p>If you're using a version control system like <tt class="docutils literal"><span class="pre">Git</span></tt> or <tt class="docutils literal"><span class="pre">Subversion</span></tt>, you
	  can setup your version control system and begin committing your project to
	  it as normal. For <tt class="docutils literal"><span class="pre">Git</span></tt>, this can be done easily with the following command:</p>
	<div class="highlight-bash"><div class="highlight"><pre>git init
	  </pre></div>
	</div>
	<p>For more information on setting up and using Git, check out the <a class="reference external" href="http://help.github.com/set-up-git-redirect">GitHub Bootcamp</a>
	  tutorials.</p>
	<div class="section" id="ignoring-the-vendor-directory">
	  <h3>Ignoring the <tt class="docutils literal"><span class="pre">vendor/</span></tt> Directory<a class="headerlink" href="#ignoring-the-vendor-directory" title="Permalink to this headline">¶</a></h3>
	  <p>If you've downloaded the archive <em>without vendors</em>, you can safely ignore
	    the entire <tt class="docutils literal"><span class="pre">vendors/</span></tt> directory and not commit it to source control. With
	    <tt class="docutils literal"><span class="pre">Git</span></tt>, this is done by creating and adding the following to a <tt class="docutils literal"><span class="pre">.gitignore</span></tt>
	    file:</p>
	  <div class="highlight-text"><div class="highlight"><pre>vendor/
	    </pre></div>
	  </div>
	  <p>Now, the vendor directory won't be committed to source control. This is fine
	    (actually, it's great!) because when someone else clones or checks out the
	    project, he/she can simply run the <tt class="docutils literal"><span class="pre">php</span> <span class="pre">bin/vendors</span> <span class="pre">install</span></tt> script to
	    download all the necessary vendor libraries.</p>
	</div>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="When Flat PHP meets Symfony" href="from_flat_php_to_symfony2.html">
      «&nbsp;When Flat PHP meets Symfony
    </a><span class="separator">|</span>
    <a accesskey="N" title="Creating Pages in Symfony2" href="page_creation.html">
      Creating Pages in Symfony2&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
