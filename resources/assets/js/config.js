export const apiDomain = "";
export const loginUrl = apiDomain + "/api/login";
export const getUserUrl = apiDomain + "/api/user";
export const getRegisterUrl = apiDomain + "/api/register";
export const getForgotUrl = apiDomain + "/api/forgot";
export const updateUser = apiDomain + "/api/user/update";

export const getTasksUrl = apiDomain + "/api/tasks";
export const getArchiveUrl = apiDomain + "/api/tasks/archive";

export const getToken = function() {
    const access_token = JSON.parse(
        window.localStorage.getItem("access_token")
    );
    const bearer = "Bearer " + access_token;

    return bearer;
};

export const userDefault = { name: "", email: "", id: "", message: "" };

export const tasksDefault = {
    delegate: [
        {
            created_at: "",
            id: "",
            importance: "",
            status: "",
            task: "",
            title: "",
            updated_at: "",
            urgency: "",
            user_id: ""
        }
    ],
    doit: [
        {
            created_at: "",
            id: "",
            importance: "",
            status: "",
            task: "",
            title: "",
            updated_at: "",
            urgency: "",
            user_id: ""
        }
    ],
    drop: [
        {
            created_at: "",
            id: "",
            importance: "",
            status: "",
            task: "",
            title: "",
            updated_at: "",
            urgency: "",
            user_id: ""
        }
    ],
    schedule: [
        {
            created_at: "",
            id: "",
            importance: "",
            status: "",
            task: "",
            title: "",
            updated_at: "",
            urgency: "",
            user_id: ""
        }
    ]
};
