export const apiDomain = 'http://localhost:8000';
export const loginUrl = apiDomain + '/api/login';
export const getUserUrl = apiDomain +'/api/user';
export const getRegisterUrl = apiDomain + '/api/register';
export const client_id = '2';
export const client_secret = '59hohUukxDdcc0uDUw0wUrj54qqZQ43PS1bU2KYv';

export const getHeader = function () {
    const access_token = JSON.parse(window.localStorage.getItem('access_token'))
    const headers = {
        'Accept': 'application/json',
        'Authorization': 'Bearer ' + access_token
    }

    return JSON.stringify(headers)
}
