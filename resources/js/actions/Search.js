import * as types from "../constants/ActionTypes";
import {get} from "./helpers";
import history from "../constants/history.js"

export const setResults = (results) => ({
    type: types.SET_RESULTS,
    data: results,
});

export const setLoading = (loading) => ({
    type: types.SET_LOADING,
    loading: loading,
});

export const search = (term) => (
    (dispatch) => {
        history.push(`/search/${term}`);
        dispatch(setLoading(true));

        return get(`search?term=${term}`)
            .then((data) => {
                dispatch(setResults(data));
                dispatch(setLoading(false));

                return data;
            });
    }
);