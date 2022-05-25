class Notification{

    success(msg)
    {
        new Noty({
            type: 'success',
            layout: 'topRight',
            text: msg,
            timeout: 1000,
         }).show();
    } 

    warning(msg)
    {
        new Noty({
            type: 'warning',
            layout: 'topRight',
            text: msg,
            timeout: 1000,
         }).show();
    } 

    error(msg)
    {
        new Noty({
            type: 'error',
            layout: 'topRight',
            text: msg,
            timeout: 1000,
         }).show();
    } 
}

export default Notification = new Notification()