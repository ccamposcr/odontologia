var repositories = {
    getClientBy: async function(searchBy, value){
        try {
            const url = 'clientes/getClientBy';
            
            const params = {
                'searchBy':searchBy,
                'value' :value
            };
            params[csrf_name] = csrf_hash;
            const response = await fetch(url, {
                credentials: 'include',
                method: 'POST',
                body: new URLSearchParams(params)
            });

            const data = await response.json();
            csrf_name = data.csrf_name;
            csrf_hash = data.csrf_hash;

            return data;
        } catch(err) {
            console.log('Error: ' + err);
        }
    },
    getRoleList: async function(){
        try {
            const url = 'generic/getRoleList';
            const response = await fetch(url);
            const data = await response.json();

            return data;
        } catch(err) {
            console.log('Error: ' + err);
        }
    },
    getJudicialStatusList: async function(){
        try {
            const url = 'generic/getJudicialStatusList';
            const response = await fetch(url);
            const data = await response.json();

            return data;
        } catch(err) {
            console.log('Error: ' + err);
        }
    },
    getSubjectList: async function(){
        try {
            const url = 'generic/getSubjectList';
            const response = await fetch(url);
            const data = await response.json();

            return data;
        } catch(err) {
            console.log('Error: ' + err);
        }
    },
    getAllClients: async function(){
        try {
            const url = 'clientes/getAllClients';
            const response = await fetch(url);
            const data = await response.json();

            return data;
        } catch(err) {
            console.log('Error: ' + err);
        }
    },
    getAllUsers: async function(){
        try {
            const url = 'clientes/getAllUsers';
            const response = await fetch(url);
            const data = await response.json();

            return data;
        } catch(err) {
            console.log('Error: ' + err);
        }
    },
    getAdministrativeStatusList: async function(){
        try {
            const url = 'generic/getAdministrativeStatusList';
            const response = await fetch(url);
            const data = await response.json();

            return data;
        } catch(err) {
            console.log('Error: ' + err);
        }
    },
    getLegalCasesBy: async function(searchBy, value){
        try {
            const url = 'casosLegales/getLegalCasesBy';

            const params = {
            'searchBy':searchBy,
            'value': value
            };
            params[csrf_name] = csrf_hash;

            const response = await fetch(url, {
            credentials: 'include',
            method: 'POST',
            body: new URLSearchParams(params)
            });

            const data = await response.json();
            csrf_name = data.csrf_name;
            csrf_hash = data.csrf_hash;

            return data;
        } catch(err) {
            console.log('Error: ' + err);
        }
    },
    getLegalCaseNotesBy: async function(searchBy, value){
        try {
            const url = 'casosLegales/getLegalCaseNotesBy';

            const params = {
            'searchBy':searchBy,
            'value': value
            };
            params[csrf_name] = csrf_hash;

            const response = await fetch(url, {
            credentials: 'include',
            method: 'POST',
            body: new URLSearchParams(params)
            });

            const data = await response.json();
            csrf_name = data.csrf_name;
            csrf_hash = data.csrf_hash;

            return data;
        } catch(err) {
            console.log('Error: ' + err);
        }
    },
    getLegalCasesByDateRange: async function(searchBy, start, end){
        try {
            const url = 'casosLegales/getLegalCasesByDateRange';

            const params = {
            'searchBy':searchBy,
            'start': start,
            'end': end
            };
            params[csrf_name] = csrf_hash;

            const response = await fetch(url, {
            credentials: 'include',
            method: 'POST',
            body: new URLSearchParams(params)
            });

            const data = await response.json();
            csrf_name = data.csrf_name;
            csrf_hash = data.csrf_hash;

            return data;
        } catch(err) {
            console.log('Error: ' + err);
        }
    },
    addLegalCaseNote: async function(params){
        try {
            const url = 'casosLegales/addLegalCaseNote';

            params[csrf_name] = csrf_hash;

            const response = await fetch(url, {
                credentials: 'include',
                method: 'POST',
                body: new URLSearchParams(params)
            });

            const data = await response.json();
            csrf_name = data.csrf_name;
            csrf_hash = data.csrf_hash;

            return data;
        } catch(err) {
            console.log('Error: ' + err);
        }
    },
    addNewClient: async function(params){
        try {
            const url = 'clientes/addClient';
            params[csrf_name] = csrf_hash;

            const response = await fetch(url, {
                credentials: 'include',
                method: 'POST',
                body: new URLSearchParams(params)
            });

            const data = await response.json();
            csrf_name = data.csrf_name;
            csrf_hash = data.csrf_hash;

            return data;
        } catch(err) {
            console.log('Error: ' + err);
        }
    },
    editClient: async function(params){
        try {
            const url = 'clientes/editClient';
            params[csrf_name] = csrf_hash;

            const response = await fetch(url, {
                credentials: 'include',
                method: 'POST',
                body: new URLSearchParams(params)
            });

            const data = await response.json();
            csrf_name = data.csrf_name;
            csrf_hash = data.csrf_hash;

            return data;
        } catch(err) {
            console.log('Error: ' + err);
        }
    },
    addNewLegalCase: async function(userID, params){
        try {
            const url = 'casosLegales/addLegalCase';
            params[csrf_name] = csrf_hash;
            params['userID'] = userID;

            const response = await fetch(url, {
                credentials: 'include',
                method: 'POST',
                body: new URLSearchParams(params)
            });

            const data = await response.json();
            csrf_name = data.csrf_name;
            csrf_hash = data.csrf_hash;

            return data;
        } catch(err) {
            console.log('Error: ' + err);
        }
    },
    editLegalCase: async function(params){
        try {
            const url = 'casosLegales/editLegalCase';
            params[csrf_name] = csrf_hash;

            const response = await fetch(url, {
            credentials: 'include',
            method: 'POST',
            body: new URLSearchParams(params)
            });

            const data = await response.json();
            csrf_name = data.csrf_name;
            csrf_hash = data.csrf_hash;

            return data;
        } catch(err) {
            console.log('Error: ' + err);
        }
    },
    addNewAppointment: async function(params){
        try {
            const url = 'citas/addAppointment';
            params[csrf_name] = csrf_hash;

            const response = await fetch(url, {
                credentials: 'include',
                method: 'POST',
                body: new URLSearchParams(params)
            });

            const data = await response.json();
            csrf_name = data.csrf_name;
            csrf_hash = data.csrf_hash;

            return data;
        } catch(err) {
            console.log('Error: ' + err);
        }
    },
    getAppointmentsByDateRange: async function(searchBy, start, end){
        try {
            const url = 'citas/getAppointmentsByDateRange';

            const params = {
            'searchBy':searchBy,
            'start': start,
            'end': end
            };
            params[csrf_name] = csrf_hash;

            const response = await fetch(url, {
            credentials: 'include',
            method: 'POST',
            body: new URLSearchParams(params)
            });

            const data = await response.json();
            csrf_name = data.csrf_name;
            csrf_hash = data.csrf_hash;
            
            return data;
        } catch(err) {
            console.log('Error: ' + err);
        }
    },
    cancelAppointment: async function(params){
        try {
            const url = 'citas/cancelAppointment';
            params[csrf_name] = csrf_hash;

            const response = await fetch(url, {
            credentials: 'include',
            method: 'POST',
            body: new URLSearchParams(params)
            });

            const data = await response.json();
            csrf_name = data.csrf_name;
            csrf_hash = data.csrf_hash;

            return data;
        } catch(err) {
            console.log('Error: ' + err);
        }
    },
    getAccessList:  async function(){
        try {
            const url = 'generic/getAccessList';
            const response = await fetch(url);
            const data = await response.json();

            return data;
        } catch(err) {
            console.log('Error: ' + err);
        }
    },
    setRolePrivilegeAccess: async function(params){
        try {
            const url = 'generic/setRolePrivilegeAccess';
            params[csrf_name] = csrf_hash;
            params.data = JSON.stringify(params.data);

            const response = await fetch(url, {
                credentials: 'include',
                method: 'POST',
                body: new URLSearchParams(params)
            });

            const data = await response.json();
            csrf_name = data.csrf_name;
            csrf_hash = data.csrf_hash;

            return data;
        } catch(err) {
            console.log('Error: ' + err);
        }
    },
    getRolePrivilegeAccess:  async function(){
        try {
            const url = 'generic/getRolePrivilegeAccess';
            const response = await fetch(url);
            const data = await response.json();

            return data;
        } catch(err) {
            console.log('Error: ' + err);
        }
    },
    getPrivilegeAccessByRole: async function(searchBy, value){
        try {
            const url = 'generic/getPrivilegeAccessByRole';

            const params = {
            'searchBy':searchBy,
            'value': value
            };
            params[csrf_name] = csrf_hash;

            const response = await fetch(url, {
            credentials: 'include',
            method: 'POST',
            body: new URLSearchParams(params)
            });

            const data = await response.json();
            csrf_name = data.csrf_name;
            csrf_hash = data.csrf_hash;

            return data;
        } catch(err) {
            console.log('Error: ' + err);
        }
    },
    deleteUser: async function(params){
        try {
            const url = 'clientes/deleteUser';
            params[csrf_name] = csrf_hash;

            const response = await fetch(url, {
                credentials: 'include',
                method: 'POST',
                body: new URLSearchParams(params)
            });

            const data = await response.json();
            csrf_name = data.csrf_name;
            csrf_hash = data.csrf_hash;

            return data;
        } catch(err) {
            console.log('Error: ' + err);
        }
    },
    updatePassword: async function(userID, params){
        try {
            const url = 'clientes/updatePassword';
            params['id'] = userID;
            params[csrf_name] = csrf_hash;

            const response = await fetch(url, {
                credentials: 'include',
                method: 'POST',
                body: new URLSearchParams(params)
            });

            const data = await response.json();
            csrf_name = data.csrf_name;
            csrf_hash = data.csrf_hash;

            return data;
        } catch(err) {
            console.log('Error: ' + err);
        }
    }
}
  
export default repositories