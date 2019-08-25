import {useDispatch} from "redux-react-hook";

export default function useBind(action) {
    const dispatch = useDispatch();
    return (...params) => (
        dispatch(action(...params))
    )
}