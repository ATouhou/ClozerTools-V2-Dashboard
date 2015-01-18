<form method="post" action="{{URL::to('createtenant')}}" />
	Tenant Name : <input type="text" name="tenant_name" / >
	Organization ID : <input type="text" name="org_id" value="1" / >
	Security Code : <input type="text" name="verify_code" value="ct-admin-123"/>

	<input type="submit" value="SUBMIT" />
</form>
<br/><br/>
<H4>Remove</h4>
	<form method="post" action="{{URL::to('removetenant')}}" />
	Tenant ID : <input type="text" name="tenant_id" / >
	Security Code : <input type="text" name="verify_code" />

	<input type="submit" value="SUBMIT" />
</form>