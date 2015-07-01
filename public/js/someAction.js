function someAction(url, ask)
{
    if(confirm(ask))
    {
        location.href=url;
    }
    return false;
}
