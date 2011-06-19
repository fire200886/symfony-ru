<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">Security Configuration Reference</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="security-configuration-reference">
      <span id="index-0"></span><h1>Security Configuration Reference<a class="headerlink" href="#security-configuration-reference" title="Permalink to this headline">¶</a></h1>
      <p>The security system is one of the most powerful parts of Symfony2, and can
	largely be controlled via its configuration.</p>
      <div class="section" id="full-default-configuration">
	<h2>Full Default Configuration<a class="headerlink" href="#full-default-configuration" title="Permalink to this headline">¶</a></h2>
	<p>The following is the full default configuration for the security system.
	  Each part will be explained in the next section.</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 2269px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><pre># app/config/security.yml
security:
    access_denied_url: /foo/error403

    always_authenticate_before_granting: false

    # strategy can be: none, migrate, invalidate
    session_fixation_strategy: migrate

    access_decision_manager:
        strategy: affirmative
        allow_if_all_abstain: false
        allow_if_equal_granted_denied: true

    acl:
        connection: default # any name configured in doctrine.dbal section
        tables:
            class: acl_classes
            entry: acl_entries
            object_identity: acl_object_identities
            object_identity_ancestors: acl_object_identity_ancestors
            security_identity: acl_security_identities
        cache:
            id: service_id
            prefix: sf2_acl_
        voter:
            allow_if_object_identity_unavailable: true

    encoders:
        somename:
            class: Acme\DemoBundle\Entity\User
        Acme\DemoBundle\Entity\User: sha512
        Acme\DemoBundle\Entity\User: plaintext
        Acme\DemoBundle\Entity\User:
            algorithm: sha512
            encode_as_base64: true
            iterations: 5000
        Acme\DemoBundle\Entity\User:
            id: my.custom.encoder.service.id

    providers:
        memory:
            name: memory
            users:
                foo: { password: foo, roles: ROLE_USER }
                bar: { password: bar, roles: [ROLE_USER, ROLE_ADMIN] }
        entity:
            entity: { class: SecurityBundle:User, property: username }

    factories:
        MyFactory: %kernel.root_dir%/../src/Acme/DemoBundle/Resources/config/security_factories.xml

    firewalls:
        somename:
            pattern: .*
            request_matcher: some.service.id
            access_denied_url: /foo/error403
            access_denied_handler: some.service.id
            entry_point: some.service.id
            provider: name
            context: name
            x509:
                provider: name
            http_basic:
                provider: name
            http_digest:
                provider: name
            form_login:
                check_path: /login_check
                login_path: /login
                use_forward: false
                always_use_default_target_path: false
                default_target_path: /
                target_path_parameter: _target_path
                use_referer: false
                failure_path: /foo
                failure_forward: false
                failure_handler: some.service.id
                success_handler: some.service.id
                username_parameter: _username
                password_parameter: _password
                csrf_parameter: _csrf_token
                csrf_page_id: form_login
                csrf_provider: my.csrf_provider.id
                post_only: true
                remember_me: false
            remember_me:
                token_provider: name
                key: someS3cretKey
                name: NameOfTheCookie
                lifetime: 3600 # in seconds
                path: /foo
                domain: somedomain.foo
                secure: true
                httponly: true
                always_remember_me: false
                remember_me_parameter: _remember_me
            logout:
                path:   /logout
                target: /
                invalidate_session: false
                delete_cookies:
                    a: { path: null, domain: null }
                    b: { path: null, domain: null }
                handlers: [some.service.id, another.service.id]
                success_handler: some.service.id
            anonymous: ~

    access_control:
        -
            path: ^/foo
            host: mydomain.foo
            ip: 192.0.0.0/8
            roles: [ROLE_A, ROLE_B]
            requires_channel: https

    role_hierarchy:
        ROLE_SUPERADMIN: ROLE_ADMIN
        ROLE_SUPERADMIN: 'ROLE_ADMIN, ROLE_USER'
        ROLE_SUPERADMIN: [ROLE_ADMIN, ROLE_USER]
        anything: { id: ROLE_SUPERADMIN, value: 'ROLE_USER, ROLE_ADMIN' }
		  anything: { id: ROLE_SUPERADMIN, value: [ROLE_USER, ROLE_ADMIN] }</pre>
	      </div>
	    </li>
	  </ul>
	</div>
      </div>
      <div class="section" id="form-login-configuration">
	<span id="reference-security-firewall-form-login"></span><h2>Form Login Configuration<a class="headerlink" href="#form-login-configuration" title="Permalink to this headline">¶</a></h2>
	<p>When using the <tt class="docutils literal"><span class="pre">form_login</span></tt> authentication listener beneath a firewall,
	  there are several common options for configuring the "form login" experience:</p>
	<div class="section" id="the-login-form-and-process">
	  <h3>The Login Form and Process<a class="headerlink" href="#the-login-form-and-process" title="Permalink to this headline">¶</a></h3>
	  <ul>
	    <li><dl class="first docutils">
		<dt><tt class="docutils literal"><span class="pre">login_path</span></tt> (type: <tt class="docutils literal"><span class="pre">string</span></tt>, default: <tt class="docutils literal"><span class="pre">/login</span></tt>)</dt>
		<dd><p class="first">This is the URL that the user will be redirected to (unless <tt class="docutils literal"><span class="pre">use_forward</span></tt>
		    is set to <tt class="docutils literal"><span class="pre">true</span></tt>) when he/she tries to access a protected resource
		    but isn't fully authenticated.</p>
		  <p class="last">This URL <strong>must</strong> be accessible by a normal, un-authenticated user, else
		    you may create a redirect loop. For details, see
		    "<a class="reference internal" href="../../book/security.html#book-security-common-pitfalls"><em>Avoid Common Pitfalls</em></a>".</p>
		</dd>
	      </dl>
	    </li>
	    <li><dl class="first docutils">
		<dt><tt class="docutils literal"><span class="pre">check_path</span></tt> (type: <tt class="docutils literal"><span class="pre">string</span></tt>, default: <tt class="docutils literal"><span class="pre">/login_check</span></tt>)</dt>
		<dd><p class="first">This is the URL that your login form must submit to. The firewall will
		    intercept any requests (<tt class="docutils literal"><span class="pre">POST</span></tt> requests only, be default) to this URL
		    and process the submitted login credentials.</p>
		  <p class="last">Be sure that this URL is covered by your main firewall (i.e. don't create
		    a separate firewall just for <tt class="docutils literal"><span class="pre">check_path</span></tt> URL).</p>
		</dd>
	      </dl>
	    </li>
	    <li><dl class="first docutils">
		<dt><tt class="docutils literal"><span class="pre">use_forward</span></tt> (type: <tt class="docutils literal"><span class="pre">Boolean</span></tt>, default: <tt class="docutils literal"><span class="pre">false</span></tt>)</dt>
		<dd><p class="first last">If you'd like the user to be forwarded to the login form instead of being
		    redirected, set this option to <tt class="docutils literal"><span class="pre">true</span></tt>.</p>
		</dd>
	      </dl>
	    </li>
	    <li><dl class="first docutils">
		<dt><tt class="docutils literal"><span class="pre">username_parameter</span></tt> (type: <tt class="docutils literal"><span class="pre">string</span></tt>, default: <tt class="docutils literal"><span class="pre">_username</span></tt>)</dt>
		<dd><p class="first last">This is the field name that you should give to the username field of
		    your login form. When you submit the form to <tt class="docutils literal"><span class="pre">check_path</span></tt>, the security
		    system will look for a POST parameter with this name.</p>
		</dd>
	      </dl>
	    </li>
	    <li><dl class="first docutils">
		<dt><tt class="docutils literal"><span class="pre">password_parameter</span></tt> (type: <tt class="docutils literal"><span class="pre">string</span></tt>, default: <tt class="docutils literal"><span class="pre">_password</span></tt>)</dt>
		<dd><p class="first last">This is the field name that you should give to the password field of
		    your login form. When you submit the form to <tt class="docutils literal"><span class="pre">check_path</span></tt>, the security
		    system will look for a POST parameter with this name.</p>
		</dd>
	      </dl>
	    </li>
	    <li><dl class="first docutils">
		<dt><tt class="docutils literal"><span class="pre">post_only</span></tt> (type: <tt class="docutils literal"><span class="pre">Boolean</span></tt>, default: <tt class="docutils literal"><span class="pre">true</span></tt>)</dt>
		<dd><p class="first last">By default, you must submit your login form to the <tt class="docutils literal"><span class="pre">check_path</span></tt> URL
		    as a POST request. By setting this option to <tt class="docutils literal"><span class="pre">true</span></tt>, you can send a
		    GET request to the <tt class="docutils literal"><span class="pre">check_path</span></tt> URL.</p>
		</dd>
	      </dl>
	    </li>
	  </ul>
	</div>
	<div class="section" id="redirecting-after-login">
	  <h3>Redirecting after Login<a class="headerlink" href="#redirecting-after-login" title="Permalink to this headline">¶</a></h3>
	  <ul class="simple">
	    <li><tt class="docutils literal"><span class="pre">always_use_default_target_path</span></tt> (type: <tt class="docutils literal"><span class="pre">Boolean</span></tt>, default: <tt class="docutils literal"><span class="pre">false</span></tt>)</li>
	    <li><tt class="docutils literal"><span class="pre">default_target_path</span></tt> (type: <tt class="docutils literal"><span class="pre">string</span></tt>, default: <tt class="docutils literal"><span class="pre">/</span></tt>)</li>
	    <li><tt class="docutils literal"><span class="pre">target_path_parameter</span></tt> (type: <tt class="docutils literal"><span class="pre">string</span></tt>, default: <tt class="docutils literal"><span class="pre">_target_path</span></tt>)</li>
	    <li><tt class="docutils literal"><span class="pre">use_referer</span></tt> (type: <tt class="docutils literal"><span class="pre">Boolean</span></tt>, default: <tt class="docutils literal"><span class="pre">false</span></tt>)</li>
	  </ul>
	</div>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="Configuration Reference" href="doctrine.html">
      «&nbsp;Configuration Reference
    </a><span class="separator">|</span>
    <a accesskey="N" title="SwiftmailerBundle Configuration" href="swiftmailer.html">
      SwiftmailerBundle Configuration&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
