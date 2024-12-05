
window.addEventListener("load",checkInternetConnection);

function checkInternetConnection(){

    const statustxt = document.getElementById('statustxt');
    const iptxt = document.getElementById('iptxt');
    const networktxt = document.getElementById('networktxt');

    statustxt.textContent = 'Checking...';

    if(navigator.onLine){
        fetch('https://api.ipify.org?format=json')
        .then((Response)=> Response.json())
        .then((data)=>{
            iptxt.textContent = data.ip;
            statustxt.textContent = 'Connected';
            const connection = navigator.connection;
            const networkStrength = connection ?connection.downlink +'Mbps' : 'Unknown';
            networktxt.textContent = networkStrength;
        })
        .catch(()=>{
        statustxt.textContent = 'Disconnected';
        iptxt.textContent = 'No internet connection available.';
        networktxt.textContent = 'Please check your network settings and try again.';
        })
    }else{
        statustxt.textContent = 'Disconnected';
        iptxt.textContent = 'No internet connection available.';
        networktxt.textContent = 'Please check your network settings and try again.';
    }
}