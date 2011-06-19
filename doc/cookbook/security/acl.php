<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">Access Control Lists (ACLs)</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="access-control-lists-acls">
      <span id="index-0"></span><h1>Access Control Lists (ACLs)<a class="headerlink" href="#access-control-lists-acls" title="Permalink to this headline">¶</a></h1>
      <p>In complex applications, you will often face the problem that access decisions
	cannot only be based on the person (<tt class="docutils literal"><span class="pre">Token</span></tt>) who is requesting access, but
	also involve a domain object that access is being requested for. This is where
	the ACL system comes in.</p>
      <p>Imagine you are designing a blog system where your users can comment on your
	posts. Now, you want a user to be able to edit his own comments, but not those
	of other users; besides, you yourself want to be able to edit all comments. In
	this scenario, <tt class="docutils literal"><span class="pre">Comment</span></tt> would be our domain object that you want to
	restrict access to. You could take several approaches to accomplish this using
	Symfony2, two basic approaches are (non-exhaustive):</p>
      <ul class="simple">
	<li><em>Enforce security in your business methods</em>: Basically, that means keeping a
	  reference inside each <tt class="docutils literal"><span class="pre">Comment</span></tt> to all users who have access, and then
	  compare these users to the provided <tt class="docutils literal"><span class="pre">Token</span></tt>.</li>
	<li><em>Enforce security with roles</em>: In this approach, you would add a role for
	  each <tt class="docutils literal"><span class="pre">Comment</span></tt> object, i.e. <tt class="docutils literal"><span class="pre">ROLE_COMMENT_1</span></tt>, <tt class="docutils literal"><span class="pre">ROLE_COMMENT_2</span></tt>, etc.</li>
      </ul>
      <p>Both approaches are perfectly valid. However, they couple your authorization
	logic to your business code which makes it less reusable elsewhere, and also
	increases the difficulty of unit testing. Besides, you could run into
	performance issues if many users would have access to a single domain object.</p>
      <p>Fortunately, there is a better way, which we will talk about now.</p>
      <div class="section" id="bootstrapping">
	<h2>Bootstrapping<a class="headerlink" href="#bootstrapping" title="Permalink to this headline">¶</a></h2>
	<p>Now, before we finally can get into action, we need to do some bootstrapping.
	  First, we need to configure the connection the ACL system is supposed to use:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 130px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/security.yml</span>
<span class="l-Scalar-Plain">security</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">acl</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">connection</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">default</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/security.xml --&gt;</span>
<span class="nt">&lt;acl&gt;</span>
    <span class="nt">&lt;connection&gt;</span>default<span class="nt">&lt;/connection&gt;</span>
<span class="nt">&lt;/acl&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/security.php</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'security'</span><span class="p">,</span> <span class="s1">'acl'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'connection'</span> <span class="o">=&gt;</span> <span class="s1">'default'</span><span class="p">,</span>
<span class="p">));</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">The ACL system requires at least one Doctrine DBAL connection to be
	      configured. However, that does not mean that you have to use Doctrine for
	      mapping your domain objects. You can use whatever mapper you like for your
	      objects, be it Doctrine ORM, Mongo ODM, Propel, or raw SQL, the choice is
	      yours.</p>
	</div></div>
	<p>After the connection is configured, we have to update the database structure:</p>
	<div class="highlight-text"><div class="highlight"><pre>php app/console doctrine:schema:update --force
	  </pre></div>
	</div>
      </div>
      <div class="section" id="getting-started">
	<h2>Getting Started<a class="headerlink" href="#getting-started" title="Permalink to this headline">¶</a></h2>
	<p>Coming back to our small example from the beginning, let's implement ACL for
	  it.</p>
	<div class="section" id="creating-an-acl-and-adding-an-ace">
	  <h3>Creating an ACL, and adding an ACE<a class="headerlink" href="#creating-an-acl-and-adding-an-ace" title="Permalink to this headline">¶</a></h3>
	  <div class="highlight-php"><div class="highlight"><pre><span class="c1">// BlogController.php</span>
<span class="k">public</span> <span class="k">function</span> <span class="nf">addCommentAction</span><span class="p">(</span><span class="nx">Post</span> <span class="nv">$post</span><span class="p">)</span>
<span class="p">{</span>
    <span class="nv">$comment</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Comment</span><span class="p">();</span>

    <span class="c1">// setup $form, and bind data</span>
    <span class="c1">// ...</span>

    <span class="k">if</span> <span class="p">(</span><span class="nv">$form</span><span class="o">-&gt;</span><span class="na">isValid</span><span class="p">())</span> <span class="p">{</span>
        <span class="nv">$entityManager</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'doctrine.orm.default_entity_manager'</span><span class="p">);</span>
        <span class="nv">$entityManager</span><span class="o">-&gt;</span><span class="na">persist</span><span class="p">(</span><span class="nv">$comment</span><span class="p">);</span>
        <span class="nv">$entityManager</span><span class="o">-&gt;</span><span class="na">flush</span><span class="p">();</span>

        <span class="c1">// creating the ACL</span>
        <span class="nv">$aclProvider</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'security.acl.provider'</span><span class="p">);</span>
        <span class="nv">$objectIdentity</span> <span class="o">=</span> <span class="nx">ObjectIdentity</span><span class="o">::</span><span class="na">fromDomainObject</span><span class="p">(</span><span class="nv">$comment</span><span class="p">);</span>
        <span class="nv">$acl</span> <span class="o">=</span> <span class="nv">$aclProvider</span><span class="o">-&gt;</span><span class="na">createAcl</span><span class="p">(</span><span class="nv">$objectIdentity</span><span class="p">);</span>

        <span class="c1">// retrieving the security identity of the currently logged-in user</span>
        <span class="nv">$securityContext</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'security.context'</span><span class="p">);</span>
        <span class="nv">$user</span> <span class="o">=</span> <span class="nv">$securityContext</span><span class="o">-&gt;</span><span class="na">getToken</span><span class="p">()</span><span class="o">-&gt;</span><span class="na">getUser</span><span class="p">();</span>
        <span class="nv">$securityIdentity</span> <span class="o">=</span> <span class="nx">UserSecurityIdentity</span><span class="o">::</span><span class="na">fromAccount</span><span class="p">(</span><span class="nv">$user</span><span class="p">);</span>

        <span class="c1">// grant owner access</span>
        <span class="nv">$acl</span><span class="o">-&gt;</span><span class="na">insertObjectAce</span><span class="p">(</span><span class="nv">$securityIdentity</span><span class="p">,</span> <span class="nx">MaskBuilder</span><span class="o">::</span><span class="na">MASK_OWNER</span><span class="p">);</span>
        <span class="nv">$aclProvider</span><span class="o">-&gt;</span><span class="na">updateAcl</span><span class="p">(</span><span class="nv">$acl</span><span class="p">);</span>
    <span class="p">}</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>There are a couple of important implementation decisions in this code snippet.
	    For now, I only want to highlight two:</p>
	  <p>First, you may have noticed that <tt class="docutils literal"><span class="pre">-&gt;createAcl()</span></tt> does not accept domain
	    objects directly, but only implementations of the <tt class="docutils literal"><span class="pre">ObjectIdentityInterface</span></tt>.
	    This additional step of indirection allows you to work with ACLs even when you
	    have no actual domain object instance at hand. This will be extremely helpful
	    if you want to check permissions for a large number of objects without
	    actually hydrating these objects.</p>
	  <p>The other interesting part is the <tt class="docutils literal"><span class="pre">-&gt;insertObjectAce()</span></tt> call. In our
	    example, we are granting the user who is currently logged in owner access to
	    the Comment. The <tt class="docutils literal"><span class="pre">MaskBuilder::MASK_OWNER</span></tt> is a pre-defined integer bitmask;
	    don't worry the mask builder will abstract away most of the technical details,
	    but using this technique we can store many different permissions in one
	    database row which gives us a considerable boost in performance.</p>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p class="last">The order in which ACEs are checked is significant. As a general rule, you
		should place more specific entries at the beginning.</p>
	  </div></div>
	</div>
	<div class="section" id="checking-access">
	  <h3>Checking Access<a class="headerlink" href="#checking-access" title="Permalink to this headline">¶</a></h3>
	  <div class="highlight-php"><div class="highlight"><pre><span class="c1">// BlogController.php</span>
<span class="k">public</span> <span class="k">function</span> <span class="nf">editCommentAction</span><span class="p">(</span><span class="nx">Comment</span> <span class="nv">$comment</span><span class="p">)</span>
<span class="p">{</span>
    <span class="nv">$securityContext</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'security.context'</span><span class="p">);</span>

    <span class="c1">// check for edit access</span>
    <span class="k">if</span> <span class="p">(</span><span class="k">false</span> <span class="o">===</span> <span class="nv">$securityContext</span><span class="o">-&gt;</span><span class="na">isGranted</span><span class="p">(</span><span class="s1">'EDIT'</span><span class="p">,</span> <span class="nv">$comment</span><span class="p">))</span>
    <span class="p">{</span>
        <span class="k">throw</span> <span class="k">new</span> <span class="nx">AccessDeniedException</span><span class="p">();</span>
    <span class="p">}</span>

    <span class="c1">// retrieve actual comment object, and do your editing here</span>
    <span class="c1">// ...</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>In this example, we check whether the user has the <tt class="docutils literal"><span class="pre">EDIT</span></tt> permission.
	    Internally, Symfony2 maps the permission to several integer bitmasks, and
	    checks whether the user has any of them.</p>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">You can define up to 32 base permissions (depending on your OS PHP might
		vary between 30 to 32). In addition, you can also define cumulative
		permissions.</p>
	  </div></div>
	</div>
      </div>
      <div class="section" id="cumulative-permissions">
	<h2>Cumulative Permissions<a class="headerlink" href="#cumulative-permissions" title="Permalink to this headline">¶</a></h2>
	<p>In our first example above, we only granted the user the <tt class="docutils literal"><span class="pre">OWNER</span></tt> base
	  permission. While this effectively also allows the user to perform any
	  operation such as view, edit, etc. on the domain object, there are cases where
	  we want to grant these permissions explicitly.</p>
	<p>The <tt class="docutils literal"><span class="pre">MaskBuilder</span></tt> can be used for creating bit masks easily by combining
	  several base permissions:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$builder</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">MaskBuilder</span><span class="p">();</span>
<span class="nv">$builder</span>
    <span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'view'</span><span class="p">)</span>
    <span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'edit'</span><span class="p">)</span>
    <span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'delete'</span><span class="p">)</span>
    <span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'undelete'</span><span class="p">)</span>
<span class="p">;</span>
<span class="nv">$mask</span> <span class="o">=</span> <span class="nv">$builder</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">();</span> <span class="c1">// int(15)</span>
	  </pre></div>
	</div>
	<p>This integer bitmask can then be used to grant a user the base permissions you
	  added above:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$acl</span><span class="o">-&gt;</span><span class="na">insertObjectAce</span><span class="p">(</span><span class="k">new</span> <span class="nx">UserSecurityIdentity</span><span class="p">(</span><span class="s1">'johannes'</span><span class="p">),</span> <span class="nv">$mask</span><span class="p">);</span>
	  </pre></div>
	</div>
	<p>The user is now allowed to view, edit, delete, and un-delete objects.</p>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="How to implement your own Voter to blacklist IP Addresses" href="voters.html">
      «&nbsp;How to implement your own Voter to blacklist IP Addresses
    </a><span class="separator">|</span>
    <a accesskey="N" title="Advanced ACL Concepts" href="acl_advanced.html">
      Advanced ACL Concepts&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
