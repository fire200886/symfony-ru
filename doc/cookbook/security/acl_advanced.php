<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">Advanced ACL Concepts</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="advanced-acl-concepts">
      <span id="index-0"></span><h1>Advanced ACL Concepts<a class="headerlink" href="#advanced-acl-concepts" title="Permalink to this headline">¶</a></h1>
      <p>The aim of this chapter is to give a more in-depth view of the ACL system, and
	also explain some of the design decisions behind it.</p>
      <div class="section" id="design-concepts">
	<h2>Design Concepts<a class="headerlink" href="#design-concepts" title="Permalink to this headline">¶</a></h2>
	<p>Symfony2's object instance security capabilities are based on the concept of
	  an Access Control List. Every domain object <strong>instance</strong> has its own ACL. The
	  ACL instance holds a detailed list of Access Control Entries (ACEs) which are
	  used to make access decisions. Symfony2's ACL system focuses on two main
	  objectives:</p>
	<ul class="simple">
	  <li>providing a way to efficiently retrieve a large amount of ACLs/ACEs for your
	    domain objects, and to modify them;</li>
	  <li>providing a way to easily make decisions of whether a person is allowed to
	    perform an action on a domain object or not.</li>
	</ul>
	<p>As indicated by the first point, one of the main capabilities of Symfony2's
	  ACL system is a high-performance way of retrieving ACLs/ACEs. This is
	  extremely important since each ACL might have several ACEs, and inherit from
	  another ACL in a tree-like fashion. Therefore, we specifically do not leverage
	  any ORM, but the default implementation interacts with your connection
	  directly using Doctrine's DBAL.</p>
	<div class="section" id="object-identities">
	  <h3>Object Identities<a class="headerlink" href="#object-identities" title="Permalink to this headline">¶</a></h3>
	  <p>The ACL system is completely decoupled from your domain objects. They don't
	    even have to be stored in the same database, or on the same server. In order
	    to achieve this decoupling, in the ACL system your objects are represented
	    through object identity objects. Everytime, you want to retrieve the ACL for a
	    domain object, the ACL system will first create an object identity from your
	    domain object, and then pass this object identity to the ACL provider for
	    further processing.</p>
	</div>
	<div class="section" id="security-identities">
	  <h3>Security Identities<a class="headerlink" href="#security-identities" title="Permalink to this headline">¶</a></h3>
	  <p>This is analog to the object identity, but represents a user, or a role in
	    your application. Each role, or user has its own security identity.</p>
	</div>
      </div>
      <div class="section" id="database-table-structure">
	<h2>Database Table Structure<a class="headerlink" href="#database-table-structure" title="Permalink to this headline">¶</a></h2>
	<p>The default implementation uses five database tables as listed below. The
	  tables are ordered from least rows to most rows in a typical application:</p>
	<ul class="simple">
	  <li><em>acl_security_identities</em>: This table records all security identities (SID)
	    which hold ACEs. The default implementation ships with two security
	    identities: <tt class="docutils literal"><span class="pre">RoleSecurityIdentity</span></tt>, and <tt class="docutils literal"><span class="pre">UserSecurityIdentity</span></tt></li>
	  <li><em>acl_classes</em>: This table maps class names to a unique id which can be
	    referenced from other tables.</li>
	  <li><em>acl_object_identities</em>: Each row in this table represents a single domain
	    object instance.</li>
	  <li><em>acl_object_identity_ancestors</em>: This table allows us to determine all the
	    ancestors of an ACL in a very efficient way.</li>
	  <li><em>acl_entries</em>: This table contains all ACEs. This is typically the table
	    with the most rows. It can contain tens of millions without significantly
	    impacting performance.</li>
	</ul>
      </div>
      <div class="section" id="scope-of-access-control-entries">
	<h2>Scope of Access Control Entries<a class="headerlink" href="#scope-of-access-control-entries" title="Permalink to this headline">¶</a></h2>
	<p>Access control entries can have different scopes in which they apply. In
	  Symfony2, we have basically two different scopes:</p>
	<ul class="simple">
	  <li>Class-Scope: These entries apply to all objects with the same class.</li>
	  <li>Object-Scope: This was the scope we solely used in the previous chapter, and
	    it only applies to one specific object.</li>
	</ul>
	<p>Sometimes, you will find the need to apply an ACE only to a specific field of
	  the object. Let's say you want the ID only to be viewable by an administrator,
	  but not by your customer service. To solve this common problem, we have added
	  two more sub-scopes:</p>
	<ul class="simple">
	  <li>Class-Field-Scope: These entries apply to all objects with the same class,
	    but only to a specific field of the objects.</li>
	  <li>Object-Field-Scope: These entries apply to a specific object, and only to a
	    specific field of that object.</li>
	</ul>
      </div>
      <div class="section" id="pre-authorization-decisions">
	<h2>Pre-Authorization Decisions<a class="headerlink" href="#pre-authorization-decisions" title="Permalink to this headline">¶</a></h2>
	<p>For pre-authorization decisions, that is decisions before any method, or
	  secure action is invoked, we rely on the proven AccessDecisionManager service
	  that is also used for reaching authorization decisions based on roles. Just
	  like roles, the ACL system adds several new attributes which may be used to
	  check for different permissions.</p>
	<div class="section" id="built-in-permission-map">
	  <h3>Built-in Permission Map<a class="headerlink" href="#built-in-permission-map" title="Permalink to this headline">¶</a></h3>
	  <table border="1" class="docutils">
	    <colgroup>
	      <col width="24%">
	      <col width="37%">
	      <col width="39%">
	    </colgroup>
	    <thead valign="bottom">
	      <tr><th class="head">Attribute</th>
		<th class="head">Intended Meaning</th>
		<th class="head">Integer Bitmasks</th>
	      </tr>
	    </thead>
	    <tbody valign="top">
	      <tr><td>VIEW</td>
		<td>Whether someone is allowed
		  to view the domain object.</td>
		<td>VIEW, EDIT, OPERATOR,
		  MASTER, or OWNER</td>
	      </tr>
	      <tr><td>EDIT</td>
		<td>Whether someone is allowed
		  to make changes to the
		  domain object.</td>
		<td>EDIT, OPERATOR, MASTER,
		  or OWNER</td>
	      </tr>
	      <tr><td>DELETE</td>
		<td>Whether someone is allowed
		  to delete the domain
		  object.</td>
		<td>DELETE, OPERATOR, MASTER,
		  or OWNER</td>
	      </tr>
	      <tr><td>UNDELETE</td>
		<td>Whether someone is allowed
		  to restore a previously
		  deleted domain object.</td>
		<td>UNDELETE, OPERATOR, MASTER,
		  or OWNER</td>
	      </tr>
	      <tr><td>OPERATOR</td>
		<td>Whether someone is allowed
		  to perform all of the above
		  actions.</td>
		<td>OPERATOR, MASTER, or OWNER</td>
	      </tr>
	      <tr><td>MASTER</td>
		<td>Whether someone is allowed
		  to perform all of the above
		  actions, and in addition is
		  allowed to grant
		  any of the above
		  permissions to others.</td>
		<td>MASTER, or OWNER</td>
	      </tr>
	      <tr><td>OWNER</td>
		<td>Whether someone owns the
		  domain object. An owner can
		  perform any of the above
		  actions.</td>
		<td>OWNER</td>
	      </tr>
	    </tbody>
	  </table>
	</div>
	<div class="section" id="permission-attributes-vs-permission-bitmasks">
	  <h3>Permission Attributes vs. Permission Bitmasks<a class="headerlink" href="#permission-attributes-vs-permission-bitmasks" title="Permalink to this headline">¶</a></h3>
	  <p>Attributes are used by the AccessDecisionManager, just like roles are
	    attributes used by the AccessDecisionManager. Often, these attributes
	    represent in fact an aggregate of integer bitmasks. Integer bitmasks on the
	    other hand, are used by the ACL system internally to efficiently store your
	    users' permissions in the database, and perform access checks using extremely
	    fast bitmask operations.</p>
	</div>
	<div class="section" id="extensibility">
	  <h3>Extensibility<a class="headerlink" href="#extensibility" title="Permalink to this headline">¶</a></h3>
	  <p>The above permission map is by no means static, and theoretically could be
	    completely replaced at will. However, it should cover most problems you
	    encounter, and for interoperability with other bundles, we encourage you to
	    stick to the meaning we have envisaged for them.</p>
	</div>
      </div>
      <div class="section" id="post-authorization-decisions">
	<h2>Post Authorization Decisions<a class="headerlink" href="#post-authorization-decisions" title="Permalink to this headline">¶</a></h2>
	<p>Post authorization decisions are made after a secure method has been invoked,
	  and typically involve the domain object which is returned by such a method.
	  After invocation providers also allow to modify, or filter the domain object
	  before it is returned.</p>
	<p>Due to current limitations of the PHP language, there are no
	  post-authorization capabilities build into the core Security component.
	  However, there is an experimental <a class="reference external" href="https://github.com/schmittjoh/SecurityExtraBundle">SecurityExtraBundle</a> which adds these
	  capabilities. See its documentation for further information on how this is
	  accomplished.</p>
      </div>
      <div class="section" id="process-for-reaching-authorization-decisions">
	<h2>Process for Reaching Authorization Decisions<a class="headerlink" href="#process-for-reaching-authorization-decisions" title="Permalink to this headline">¶</a></h2>
	<p>The ACL class provides two methods for determining whether a security identity
	  has the required bitmasks, <tt class="docutils literal"><span class="pre">isGranted</span></tt> and <tt class="docutils literal"><span class="pre">isFieldGranted</span></tt>. When the ACL
	  receives an authorization request through one of these methods, it delegates
	  this request to an implementation of PermissionGrantingStrategy. This allows
	  you to replace the way access decisions are reached without actually modifying
	  the ACL class itself.</p>
	<p>The PermissionGrantingStrategy first checks all your object-scope ACEs if none
	  is applicable, the class-scope ACEs will be checked, if none is applicable,
	  then the process will be repeated with the ACEs of the parent ACL. If no
	  parent ACL exists, an exception will be thrown.</p>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="Access Control Lists (ACLs)" href="acl.html">
      «&nbsp;Access Control Lists (ACLs)
    </a><span class="separator">|</span>
    <a accesskey="N" title="How to force HTTPS or HTTP for Different URLs" href="force_https.html">
      How to force HTTPS or HTTP for Different URLs&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
