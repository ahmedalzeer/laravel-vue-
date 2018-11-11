export default class Gate {
    constructor(user)
    {
        this.user = user;
    }
    isadmin()
    {
        return this.user.role === 'admin';
    }
    isauthorOrisadmin()
    {
        if (this.user.role === 'admin' || this.user.role === 'author')
        {
            return true;
        }
    }
    isuserOrisadmin()
    {
        if (this.user.role === 'user' || this.user.role === 'author')
        {
            return true;
        }
    }
    isuser()
    {
        return this.user.role === 'user';
    }
}
