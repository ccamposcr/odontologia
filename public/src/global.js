var global = {
   checkAccessList: function(action){
       const actionID = loggedINAccessList.filter( entry => { return entry.action === action; });
       return loggedINRoleAccessList.includes(actionID[0].id);
   }
}
  
export default global