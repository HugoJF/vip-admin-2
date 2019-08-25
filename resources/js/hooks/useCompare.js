import {usePrevious} from "./usePrevious";

export const useCompare = (val) => {
    const prevVal = usePrevious(val);
    return prevVal !== val
};