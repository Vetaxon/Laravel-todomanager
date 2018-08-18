export const apiDomain = 'http://localhost:8000';
export const loginUrl = apiDomain + '/api/login';
export const getUserUrl = apiDomain +'/api/user';
export const getRegisterUrl = apiDomain + '/api/register';
export const getTasksUrl = apiDomain + '/api/tasks';
export const updateUser = apiDomain + '/api/user/update'
export const client_id = '2';
export const client_secret = '59hohUukxDdcc0uDUw0wUrj54qqZQ43PS1bU2KYv';

export const getToken = function () {
    const access_token = JSON.parse(window.localStorage.getItem('access_token'))
    const bearer = "Bearer " + access_token

    return bearer
}
