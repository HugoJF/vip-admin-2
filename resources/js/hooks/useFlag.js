import {useDispatch} from "redux-react-hook";
import {useCallback} from "react";
import {useMappedState} from "redux-react-hook";
import {setFlag} from "../actions/Flags";
import useFastState from "./useFastState";
import useReactRouter from "use-react-router/use-react-router";

/**
 * Returns a getter and setter for provided flag
 * @param key - flag key
 * @returns {*[]}
 */
export default function useFlag(key) {
    const dispatch = useDispatch();

    const flag = useFastState('flags')[key];

    const set = (value) => dispatch(setFlag(key, value));
    const get = () => flag;

    return [get, set];
}