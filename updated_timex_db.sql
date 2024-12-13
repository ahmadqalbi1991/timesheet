--
-- PostgreSQL database dump
--

-- Dumped from database version 15.2
-- Dumped by pg_dump version 15.2

-- Started on 2023-04-26 11:26:21

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 2 (class 3079 OID 41135)
-- Name: postgis; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS postgis WITH SCHEMA public;


--
-- TOC entry 4512 (class 0 OID 0)
-- Dependencies: 2
-- Name: EXTENSION postgis; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION postgis IS 'PostGIS geometry and geography spatial types and functions';


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 258 (class 1259 OID 42241)
-- Name: booking_qoutes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.booking_qoutes (
    id bigint NOT NULL,
    booking_id bigint NOT NULL,
    driver_id bigint NOT NULL,
    price double precision NOT NULL,
    hours integer NOT NULL,
    status character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    comission_amount double precision DEFAULT '0'::double precision NOT NULL,
    is_admin_approved character varying(255) DEFAULT 'no'::character varying NOT NULL,
    CONSTRAINT booking_qoutes_is_admin_approved_check CHECK (((is_admin_approved)::text = ANY ((ARRAY['no'::character varying, 'yes'::character varying])::text[]))),
    CONSTRAINT booking_qoutes_status_check CHECK (((status)::text = ANY ((ARRAY['pending'::character varying, 'qouted'::character varying, 'accepted'::character varying, 'rejected'::character varying])::text[])))
);


ALTER TABLE public.booking_qoutes OWNER TO postgres;

--
-- TOC entry 257 (class 1259 OID 42240)
-- Name: booking_qoutes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.booking_qoutes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.booking_qoutes_id_seq OWNER TO postgres;

--
-- TOC entry 4513 (class 0 OID 0)
-- Dependencies: 257
-- Name: booking_qoutes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.booking_qoutes_id_seq OWNED BY public.booking_qoutes.id;


--
-- TOC entry 260 (class 1259 OID 42249)
-- Name: booking_reviews; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.booking_reviews (
    id bigint NOT NULL,
    booking_id bigint NOT NULL,
    driver_id bigint NOT NULL,
    customer_id bigint NOT NULL,
    rate integer NOT NULL,
    comment text NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.booking_reviews OWNER TO postgres;

--
-- TOC entry 259 (class 1259 OID 42248)
-- Name: booking_reviews_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.booking_reviews_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.booking_reviews_id_seq OWNER TO postgres;

--
-- TOC entry 4514 (class 0 OID 0)
-- Dependencies: 259
-- Name: booking_reviews_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.booking_reviews_id_seq OWNED BY public.booking_reviews.id;


--
-- TOC entry 268 (class 1259 OID 42321)
-- Name: bookings; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.bookings (
    id bigint NOT NULL,
    collection_address text NOT NULL,
    deliver_address text NOT NULL,
    sender_id bigint NOT NULL,
    receiver_name character varying(255) NOT NULL,
    receiver_email character varying(255) NOT NULL,
    receiver_phone character varying(255) NOT NULL,
    deligate_id bigint NOT NULL,
    deligate_details text NOT NULL,
    truck_type_id bigint,
    quantity integer NOT NULL,
    admin_response character varying(255) NOT NULL,
    qouted_amount double precision,
    comission_amount double precision,
    customer_signature integer,
    delivery_note text,
    driver_id bigint,
    status character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    awb_number character varying(255),
    booking_number character varying(255),
    is_paid character varying(255) DEFAULT 'no'::character varying NOT NULL,
    total_amount integer,
    CONSTRAINT bookings_admin_response_check CHECK (((admin_response)::text = ANY (ARRAY[('pending'::character varying)::text, ('ask_for_qoute'::character varying)::text, ('driver_qouted'::character varying)::text, ('approved_by_admin'::character varying)::text]))),
    CONSTRAINT bookings_is_paid_check CHECK (((is_paid)::text = ANY ((ARRAY['no'::character varying, 'yes'::character varying])::text[]))),
    CONSTRAINT bookings_status_check CHECK (((status)::text = ANY (ARRAY[('pending'::character varying)::text, ('qouted'::character varying)::text, ('accepted'::character varying)::text, ('journey_started'::character varying)::text, ('item_collected'::character varying)::text, ('on_the_way'::character varying)::text, ('border_crossing'::character varying)::text, ('custom_clearance'::character varying)::text, ('delivered'::character varying)::text])))
);


ALTER TABLE public.bookings OWNER TO postgres;

--
-- TOC entry 269 (class 1259 OID 42328)
-- Name: bookings_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.bookings_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.bookings_id_seq OWNER TO postgres;

--
-- TOC entry 4515 (class 0 OID 0)
-- Dependencies: 269
-- Name: bookings_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.bookings_id_seq OWNED BY public.bookings.id;


--
-- TOC entry 227 (class 1259 OID 41059)
-- Name: categories; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.categories (
    category_id integer NOT NULL,
    lang_code character varying(5) DEFAULT 'en'::character varying NOT NULL,
    category_name character varying(256) NOT NULL,
    unique_category_code character varying(128) NOT NULL,
    unique_category_text character varying(128) NOT NULL,
    category_image character varying(512),
    category_icon character varying(512),
    created_by integer NOT NULL,
    parent_category_id integer DEFAULT 0 NOT NULL,
    category_status smallint DEFAULT '1'::smallint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.categories OWNER TO postgres;

--
-- TOC entry 4516 (class 0 OID 0)
-- Dependencies: 227
-- Name: COLUMN categories.category_name; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.categories.category_name IS 'should be in lowercase';


--
-- TOC entry 4517 (class 0 OID 0)
-- Dependencies: 227
-- Name: COLUMN categories.unique_category_code; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.categories.unique_category_code IS 'a unique code created during the category creation';


--
-- TOC entry 4518 (class 0 OID 0)
-- Dependencies: 227
-- Name: COLUMN categories.unique_category_text; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.categories.unique_category_text IS 'a unique code category text using category name field, usally used in website for better seo';


--
-- TOC entry 4519 (class 0 OID 0)
-- Dependencies: 227
-- Name: COLUMN categories.category_image; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.categories.category_image IS 'category image/logo file';


--
-- TOC entry 4520 (class 0 OID 0)
-- Dependencies: 227
-- Name: COLUMN categories.category_icon; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.categories.category_icon IS 'category image/logo file';


--
-- TOC entry 4521 (class 0 OID 0)
-- Dependencies: 227
-- Name: COLUMN categories.category_status; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.categories.category_status IS '0-inactive,1-active';


--
-- TOC entry 226 (class 1259 OID 41058)
-- Name: categories_category_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.categories_category_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.categories_category_id_seq OWNER TO postgres;

--
-- TOC entry 4522 (class 0 OID 0)
-- Dependencies: 226
-- Name: categories_category_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.categories_category_id_seq OWNED BY public.categories.category_id;


--
-- TOC entry 229 (class 1259 OID 41071)
-- Name: category_languages; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.category_languages (
    category_lang_id integer NOT NULL,
    category_id_fk integer NOT NULL,
    lang_code character varying(5) NOT NULL,
    category_localized_name character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.category_languages OWNER TO postgres;

--
-- TOC entry 228 (class 1259 OID 41070)
-- Name: category_languages_category_lang_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.category_languages_category_lang_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.category_languages_category_lang_id_seq OWNER TO postgres;

--
-- TOC entry 4523 (class 0 OID 0)
-- Dependencies: 228
-- Name: category_languages_category_lang_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.category_languages_category_lang_id_seq OWNED BY public.category_languages.category_lang_id;


--
-- TOC entry 256 (class 1259 OID 42220)
-- Name: companies; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.companies (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    logo character varying(255) NOT NULL,
    status character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    company_license character varying(255),
    CONSTRAINT companies_status_check CHECK (((status)::text = ANY ((ARRAY['active'::character varying, 'inactive'::character varying])::text[])))
);


ALTER TABLE public.companies OWNER TO postgres;

--
-- TOC entry 255 (class 1259 OID 42219)
-- Name: companies_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.companies_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.companies_id_seq OWNER TO postgres;

--
-- TOC entry 4524 (class 0 OID 0)
-- Dependencies: 255
-- Name: companies_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.companies_id_seq OWNED BY public.companies.id;


--
-- TOC entry 233 (class 1259 OID 41087)
-- Name: countries; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.countries (
    country_id integer NOT NULL,
    country_name character varying(128) NOT NULL,
    dial_code character varying(16) NOT NULL,
    iso_code character varying(16) NOT NULL,
    lang_code character varying(4) NOT NULL,
    country_status integer DEFAULT 1 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.countries OWNER TO postgres;

--
-- TOC entry 232 (class 1259 OID 41086)
-- Name: countries_country_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.countries_country_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.countries_country_id_seq OWNER TO postgres;

--
-- TOC entry 4525 (class 0 OID 0)
-- Dependencies: 232
-- Name: countries_country_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.countries_country_id_seq OWNED BY public.countries.country_id;


--
-- TOC entry 235 (class 1259 OID 41095)
-- Name: country_languages; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.country_languages (
    country_lang_id integer NOT NULL,
    lang_code character varying(4) NOT NULL,
    country_id_fk integer NOT NULL,
    country_localized_name character varying(128) NOT NULL
);


ALTER TABLE public.country_languages OWNER TO postgres;

--
-- TOC entry 234 (class 1259 OID 41094)
-- Name: country_languages_country_lang_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.country_languages_country_lang_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.country_languages_country_lang_id_seq OWNER TO postgres;

--
-- TOC entry 4526 (class 0 OID 0)
-- Dependencies: 234
-- Name: country_languages_country_lang_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.country_languages_country_lang_id_seq OWNED BY public.country_languages.country_lang_id;


--
-- TOC entry 254 (class 1259 OID 42211)
-- Name: deligate_attributes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.deligate_attributes (
    id bigint NOT NULL,
    deligate_id bigint NOT NULL,
    details text NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    name character varying(255)
);


ALTER TABLE public.deligate_attributes OWNER TO postgres;

--
-- TOC entry 253 (class 1259 OID 42210)
-- Name: deligate_attributes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.deligate_attributes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.deligate_attributes_id_seq OWNER TO postgres;

--
-- TOC entry 4527 (class 0 OID 0)
-- Dependencies: 253
-- Name: deligate_attributes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.deligate_attributes_id_seq OWNED BY public.deligate_attributes.id;


--
-- TOC entry 252 (class 1259 OID 42201)
-- Name: deligates; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.deligates (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    icon character varying(255) NOT NULL,
    status character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    slug character varying(255),
    CONSTRAINT deligates_status_check CHECK (((status)::text = ANY ((ARRAY['active'::character varying, 'inactive'::character varying])::text[])))
);


ALTER TABLE public.deligates OWNER TO postgres;

--
-- TOC entry 251 (class 1259 OID 42200)
-- Name: deligates_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.deligates_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.deligates_id_seq OWNER TO postgres;

--
-- TOC entry 4528 (class 0 OID 0)
-- Dependencies: 251
-- Name: deligates_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.deligates_id_seq OWNED BY public.deligates.id;


--
-- TOC entry 248 (class 1259 OID 42180)
-- Name: driver_details; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.driver_details (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    driving_license character varying(255) NOT NULL,
    mulkia character varying(255) NOT NULL,
    mulkia_number character varying(255) NOT NULL,
    is_company character varying(255) DEFAULT 'no'::character varying NOT NULL,
    company_id bigint NOT NULL,
    truck_type_id bigint NOT NULL,
    total_rides integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    address character varying(255),
    latitude character varying(255),
    longitude character varying(255),
    CONSTRAINT driver_details_is_company_check CHECK (((is_company)::text = ANY ((ARRAY['yes'::character varying, 'no'::character varying])::text[])))
);


ALTER TABLE public.driver_details OWNER TO postgres;

--
-- TOC entry 247 (class 1259 OID 42179)
-- Name: driver_details_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.driver_details_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.driver_details_id_seq OWNER TO postgres;

--
-- TOC entry 4529 (class 0 OID 0)
-- Dependencies: 247
-- Name: driver_details_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.driver_details_id_seq OWNED BY public.driver_details.id;


--
-- TOC entry 267 (class 1259 OID 42282)
-- Name: driver_types; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.driver_types (
    id integer NOT NULL,
    type character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.driver_types OWNER TO postgres;

--
-- TOC entry 241 (class 1259 OID 41121)
-- Name: event_invitations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.event_invitations (
    id bigint NOT NULL,
    event_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    is_allowed_to_invite boolean NOT NULL,
    show_guest_list boolean NOT NULL,
    status integer DEFAULT 1 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.event_invitations OWNER TO postgres;

--
-- TOC entry 240 (class 1259 OID 41120)
-- Name: event_invitations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.event_invitations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.event_invitations_id_seq OWNER TO postgres;

--
-- TOC entry 4530 (class 0 OID 0)
-- Dependencies: 240
-- Name: event_invitations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.event_invitations_id_seq OWNED BY public.event_invitations.id;


--
-- TOC entry 239 (class 1259 OID 41111)
-- Name: events; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.events (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    date date NOT NULL,
    start_time character varying(255) NOT NULL,
    end_time character varying(255) NOT NULL,
    event_type_id integer NOT NULL,
    about text NOT NULL,
    privacy character varying(255) NOT NULL,
    image character varying(255) NOT NULL,
    address text NOT NULL,
    latitude character varying(255) NOT NULL,
    longitude character varying(255) NOT NULL,
    building character varying(255),
    apartment character varying(255),
    landmark character varying(255),
    active boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.events OWNER TO postgres;

--
-- TOC entry 238 (class 1259 OID 41110)
-- Name: events_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.events_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.events_id_seq OWNER TO postgres;

--
-- TOC entry 4531 (class 0 OID 0)
-- Dependencies: 238
-- Name: events_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.events_id_seq OWNED BY public.events.id;


--
-- TOC entry 223 (class 1259 OID 41035)
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO postgres;

--
-- TOC entry 222 (class 1259 OID 41034)
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.failed_jobs_id_seq OWNER TO postgres;

--
-- TOC entry 4532 (class 0 OID 0)
-- Dependencies: 222
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- TOC entry 237 (class 1259 OID 41102)
-- Name: languages; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.languages (
    language_id integer NOT NULL,
    language_name character varying(255) NOT NULL,
    lang_code character varying(4) DEFAULT 'en'::character varying NOT NULL,
    language_status integer DEFAULT 1 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.languages OWNER TO postgres;

--
-- TOC entry 236 (class 1259 OID 41101)
-- Name: languages_language_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.languages_language_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.languages_language_id_seq OWNER TO postgres;

--
-- TOC entry 4533 (class 0 OID 0)
-- Dependencies: 236
-- Name: languages_language_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.languages_language_id_seq OWNED BY public.languages.language_id;


--
-- TOC entry 216 (class 1259 OID 40999)
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- TOC entry 215 (class 1259 OID 40998)
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.migrations_id_seq OWNER TO postgres;

--
-- TOC entry 4534 (class 0 OID 0)
-- Dependencies: 215
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- TOC entry 271 (class 1259 OID 44950)
-- Name: new_notifications; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.new_notifications (
    id bigint NOT NULL,
    user_id integer NOT NULL,
    description character varying(255) NOT NULL,
    generated_by bigint,
    generated_to bigint,
    is_read character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    title character varying(255),
    image character varying(255),
    CONSTRAINT new_notifications_is_read_check CHECK (((is_read)::text = ANY ((ARRAY['yes'::character varying, 'no'::character varying])::text[])))
);


ALTER TABLE public.new_notifications OWNER TO postgres;

--
-- TOC entry 270 (class 1259 OID 44949)
-- Name: new_notifications_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.new_notifications_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.new_notifications_id_seq OWNER TO postgres;

--
-- TOC entry 4535 (class 0 OID 0)
-- Dependencies: 270
-- Name: new_notifications_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.new_notifications_id_seq OWNED BY public.new_notifications.id;


--
-- TOC entry 266 (class 1259 OID 42273)
-- Name: notifications; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.notifications (
    id bigint NOT NULL,
    type character varying(255) NOT NULL,
    content character varying(255) NOT NULL,
    generated_by bigint NOT NULL,
    generated_to bigint NOT NULL,
    is_read character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT notifications_is_read_check CHECK (((is_read)::text = ANY ((ARRAY['yes'::character varying, 'no'::character varying])::text[])))
);


ALTER TABLE public.notifications OWNER TO postgres;

--
-- TOC entry 265 (class 1259 OID 42272)
-- Name: notifications_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.notifications_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.notifications_id_seq OWNER TO postgres;

--
-- TOC entry 4536 (class 0 OID 0)
-- Dependencies: 265
-- Name: notifications_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.notifications_id_seq OWNED BY public.notifications.id;


--
-- TOC entry 221 (class 1259 OID 41028)
-- Name: password_resets; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.password_resets (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_resets OWNER TO postgres;

--
-- TOC entry 225 (class 1259 OID 41047)
-- Name: personal_access_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.personal_access_tokens (
    id bigint NOT NULL,
    tokenable_type character varying(255) NOT NULL,
    tokenable_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    token character varying(64) NOT NULL,
    abilities text,
    last_used_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.personal_access_tokens OWNER TO postgres;

--
-- TOC entry 224 (class 1259 OID 41046)
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.personal_access_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.personal_access_tokens_id_seq OWNER TO postgres;

--
-- TOC entry 4537 (class 0 OID 0)
-- Dependencies: 224
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.personal_access_tokens_id_seq OWNED BY public.personal_access_tokens.id;


--
-- TOC entry 231 (class 1259 OID 41078)
-- Name: role_permissions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.role_permissions (
    permission_id integer NOT NULL,
    user_role_id_fk integer NOT NULL,
    module_key character varying(255) NOT NULL,
    permissions text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.role_permissions OWNER TO postgres;

--
-- TOC entry 230 (class 1259 OID 41077)
-- Name: role_permissions_permission_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.role_permissions_permission_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.role_permissions_permission_id_seq OWNER TO postgres;

--
-- TOC entry 4538 (class 0 OID 0)
-- Dependencies: 230
-- Name: role_permissions_permission_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.role_permissions_permission_id_seq OWNED BY public.role_permissions.permission_id;


--
-- TOC entry 218 (class 1259 OID 41006)
-- Name: roles; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.roles (
    id integer NOT NULL,
    role character varying(255) NOT NULL,
    status character varying(255) DEFAULT 'active'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT roles_status_check CHECK (((status)::text = ANY ((ARRAY['active'::character varying, 'inactive'::character varying])::text[])))
);


ALTER TABLE public.roles OWNER TO postgres;

--
-- TOC entry 217 (class 1259 OID 41005)
-- Name: roles_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.roles_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.roles_id_seq OWNER TO postgres;

--
-- TOC entry 4539 (class 0 OID 0)
-- Dependencies: 217
-- Name: roles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.roles_id_seq OWNED BY public.roles.id;


--
-- TOC entry 250 (class 1259 OID 42191)
-- Name: truck_types; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.truck_types (
    id bigint NOT NULL,
    truck_type character varying(255) NOT NULL,
    dimensions character varying(255) NOT NULL,
    icon character varying(255) NOT NULL,
    status character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT truck_types_status_check CHECK (((status)::text = ANY ((ARRAY['active'::character varying, 'inactive'::character varying])::text[])))
);


ALTER TABLE public.truck_types OWNER TO postgres;

--
-- TOC entry 249 (class 1259 OID 42190)
-- Name: truck_types_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.truck_types_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.truck_types_id_seq OWNER TO postgres;

--
-- TOC entry 4540 (class 0 OID 0)
-- Dependencies: 249
-- Name: truck_types_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.truck_types_id_seq OWNED BY public.truck_types.id;


--
-- TOC entry 264 (class 1259 OID 42265)
-- Name: user_wallet_transactions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.user_wallet_transactions (
    id bigint NOT NULL,
    user_wallet_id bigint NOT NULL,
    amount integer NOT NULL,
    type character varying(255) NOT NULL,
    created_by bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT user_wallet_transactions_type_check CHECK (((type)::text = ANY ((ARRAY['credit'::character varying, 'debit'::character varying])::text[])))
);


ALTER TABLE public.user_wallet_transactions OWNER TO postgres;

--
-- TOC entry 263 (class 1259 OID 42264)
-- Name: user_wallet_transactions_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.user_wallet_transactions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.user_wallet_transactions_id_seq OWNER TO postgres;

--
-- TOC entry 4541 (class 0 OID 0)
-- Dependencies: 263
-- Name: user_wallet_transactions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.user_wallet_transactions_id_seq OWNED BY public.user_wallet_transactions.id;


--
-- TOC entry 262 (class 1259 OID 42258)
-- Name: user_wallets; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.user_wallets (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    amount integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.user_wallets OWNER TO postgres;

--
-- TOC entry 261 (class 1259 OID 42257)
-- Name: user_wallets_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.user_wallets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.user_wallets_id_seq OWNER TO postgres;

--
-- TOC entry 4542 (class 0 OID 0)
-- Dependencies: 261
-- Name: user_wallets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.user_wallets_id_seq OWNED BY public.user_wallets.id;


--
-- TOC entry 220 (class 1259 OID 41017)
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255),
    email character varying(255),
    dial_code character varying(255),
    phone character varying(255),
    phone_verified integer DEFAULT 0 NOT NULL,
    password character varying(255),
    email_verified_at timestamp(0) without time zone,
    role_id bigint NOT NULL,
    user_phone_otp character varying(255),
    user_device_token character varying(255),
    user_device_type character varying(255),
    user_access_token character varying(255),
    firebase_user_key character varying(255),
    status character varying(255) DEFAULT 'inactive'::character varying NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    provider_id character varying(255),
    avatar character varying(255),
    address text,
    profile_image character varying(255),
    CONSTRAINT users_status_check CHECK (((status)::text = ANY ((ARRAY['active'::character varying, 'inactive'::character varying])::text[])))
);


ALTER TABLE public.users OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 41016)
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO postgres;

--
-- TOC entry 4543 (class 0 OID 0)
-- Dependencies: 219
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- TOC entry 4224 (class 2604 OID 42244)
-- Name: booking_qoutes id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_qoutes ALTER COLUMN id SET DEFAULT nextval('public.booking_qoutes_id_seq'::regclass);


--
-- TOC entry 4227 (class 2604 OID 42252)
-- Name: booking_reviews id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_reviews ALTER COLUMN id SET DEFAULT nextval('public.booking_reviews_id_seq'::regclass);


--
-- TOC entry 4231 (class 2604 OID 42332)
-- Name: bookings id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bookings ALTER COLUMN id SET DEFAULT nextval('public.bookings_id_seq'::regclass);


--
-- TOC entry 4202 (class 2604 OID 41062)
-- Name: categories category_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories ALTER COLUMN category_id SET DEFAULT nextval('public.categories_category_id_seq'::regclass);


--
-- TOC entry 4206 (class 2604 OID 41074)
-- Name: category_languages category_lang_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.category_languages ALTER COLUMN category_lang_id SET DEFAULT nextval('public.category_languages_category_lang_id_seq'::regclass);


--
-- TOC entry 4223 (class 2604 OID 42223)
-- Name: companies id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.companies ALTER COLUMN id SET DEFAULT nextval('public.companies_id_seq'::regclass);


--
-- TOC entry 4208 (class 2604 OID 41090)
-- Name: countries country_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.countries ALTER COLUMN country_id SET DEFAULT nextval('public.countries_country_id_seq'::regclass);


--
-- TOC entry 4210 (class 2604 OID 41098)
-- Name: country_languages country_lang_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.country_languages ALTER COLUMN country_lang_id SET DEFAULT nextval('public.country_languages_country_lang_id_seq'::regclass);


--
-- TOC entry 4222 (class 2604 OID 42214)
-- Name: deligate_attributes id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.deligate_attributes ALTER COLUMN id SET DEFAULT nextval('public.deligate_attributes_id_seq'::regclass);


--
-- TOC entry 4221 (class 2604 OID 42204)
-- Name: deligates id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.deligates ALTER COLUMN id SET DEFAULT nextval('public.deligates_id_seq'::regclass);


--
-- TOC entry 4218 (class 2604 OID 42183)
-- Name: driver_details id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.driver_details ALTER COLUMN id SET DEFAULT nextval('public.driver_details_id_seq'::regclass);


--
-- TOC entry 4216 (class 2604 OID 41124)
-- Name: event_invitations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.event_invitations ALTER COLUMN id SET DEFAULT nextval('public.event_invitations_id_seq'::regclass);


--
-- TOC entry 4214 (class 2604 OID 41114)
-- Name: events id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.events ALTER COLUMN id SET DEFAULT nextval('public.events_id_seq'::regclass);


--
-- TOC entry 4199 (class 2604 OID 41038)
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- TOC entry 4211 (class 2604 OID 41105)
-- Name: languages language_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.languages ALTER COLUMN language_id SET DEFAULT nextval('public.languages_language_id_seq'::regclass);


--
-- TOC entry 4193 (class 2604 OID 41002)
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- TOC entry 4233 (class 2604 OID 44953)
-- Name: new_notifications id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.new_notifications ALTER COLUMN id SET DEFAULT nextval('public.new_notifications_id_seq'::regclass);


--
-- TOC entry 4230 (class 2604 OID 42276)
-- Name: notifications id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notifications ALTER COLUMN id SET DEFAULT nextval('public.notifications_id_seq'::regclass);


--
-- TOC entry 4201 (class 2604 OID 41050)
-- Name: personal_access_tokens id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens ALTER COLUMN id SET DEFAULT nextval('public.personal_access_tokens_id_seq'::regclass);


--
-- TOC entry 4207 (class 2604 OID 41081)
-- Name: role_permissions permission_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.role_permissions ALTER COLUMN permission_id SET DEFAULT nextval('public.role_permissions_permission_id_seq'::regclass);


--
-- TOC entry 4194 (class 2604 OID 41009)
-- Name: roles id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles ALTER COLUMN id SET DEFAULT nextval('public.roles_id_seq'::regclass);


--
-- TOC entry 4220 (class 2604 OID 42194)
-- Name: truck_types id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.truck_types ALTER COLUMN id SET DEFAULT nextval('public.truck_types_id_seq'::regclass);


--
-- TOC entry 4229 (class 2604 OID 42268)
-- Name: user_wallet_transactions id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_wallet_transactions ALTER COLUMN id SET DEFAULT nextval('public.user_wallet_transactions_id_seq'::regclass);


--
-- TOC entry 4228 (class 2604 OID 42261)
-- Name: user_wallets id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_wallets ALTER COLUMN id SET DEFAULT nextval('public.user_wallets_id_seq'::regclass);


--
-- TOC entry 4196 (class 2604 OID 41020)
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- TOC entry 4493 (class 0 OID 42241)
-- Dependencies: 258
-- Data for Name: booking_qoutes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.booking_qoutes (id, booking_id, driver_id, price, hours, status, created_at, updated_at, comission_amount, is_admin_approved) FROM stdin;
94	45	20	0	0	pending	2023-04-25 16:01:52	2023-04-25 16:01:52	0	no
95	46	20	230	20	qouted	2023-04-25 16:06:04	2023-04-25 16:14:21	0	yes
96	47	20	0	0	pending	2023-04-26 08:53:07	2023-04-26 08:53:07	0	no
97	47	20	0	0	pending	2023-04-26 08:53:50	2023-04-26 08:53:50	0	no
98	48	16	0	0	pending	2023-04-26 08:57:59	2023-04-26 08:57:59	0	no
99	50	20	0	0	pending	2023-04-26 09:47:36	2023-04-26 09:47:36	0	no
100	50	16	0	0	pending	2023-04-26 09:47:36	2023-04-26 09:47:36	0	no
101	51	20	0	0	pending	2023-04-26 09:47:36	2023-04-26 09:47:36	0	no
102	51	16	0	0	pending	2023-04-26 09:47:36	2023-04-26 09:47:36	0	no
103	52	20	0	0	pending	2023-04-26 09:47:36	2023-04-26 09:47:36	0	no
104	52	16	0	0	pending	2023-04-26 09:47:36	2023-04-26 09:47:36	0	no
105	53	20	0	0	pending	2023-04-26 09:47:36	2023-04-26 09:47:36	0	no
106	53	16	0	0	pending	2023-04-26 09:47:36	2023-04-26 09:47:36	0	no
83	29	16	200	10	accepted	2023-04-24 23:44:40	2023-04-25 01:34:52	0	yes
82	29	20	200	10	rejected	2023-04-24 23:44:40	2023-04-25 01:38:21	0	yes
\.


--
-- TOC entry 4495 (class 0 OID 42249)
-- Dependencies: 260
-- Data for Name: booking_reviews; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.booking_reviews (id, booking_id, driver_id, customer_id, rate, comment, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 4503 (class 0 OID 42321)
-- Dependencies: 268
-- Data for Name: bookings; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.bookings (id, collection_address, deliver_address, sender_id, receiver_name, receiver_email, receiver_phone, deligate_id, deligate_details, truck_type_id, quantity, admin_response, qouted_amount, comission_amount, customer_signature, delivery_note, driver_id, status, created_at, updated_at, awb_number, booking_number, is_paid, total_amount) FROM stdin;
50	Po Box 30499 Jebel Ali Free Zone	P.O. Box: 23318, SHARJAH U A E	15	receiver_name	ghaniabro11@gmail.com	receiver_phone	2	truck	2	1	ask_for_qoute	\N	2	\N	\N	\N	pending	2023-04-26 09:47:36	2023-04-26 09:47:36	\N	#TX-000050	no	\N
51	Po Box 30499 Jebel Ali Free Zone	P.O. Box: 23318, SHARJAH U A E	15	receiver_name	ghaniabro11@gmail.com	receiver_phone	2	truck	2	1	ask_for_qoute	\N	1	\N	\N	\N	pending	2023-04-26 09:47:36	2023-04-26 09:47:36	\N	#TX-000051	no	\N
52	Po Box 30499 Jebel Ali Free Zone	P.O. Box: 23318, SHARJAH U A E	15	receiver_name	ghaniabro11@gmail.com	receiver_phone	2	truck	2	1	ask_for_qoute	\N	3	\N	\N	\N	pending	2023-04-26 09:47:36	2023-04-26 09:47:36	\N	#TX-000052	no	\N
48	Truck Type addres	abc	15	Daniel	daniel@email.com	971 181881818181	3	{"weight":"10","no_of_crts":"2","crt_dimension":"33","no_of_pallets":"2"}	2	1	ask_for_qoute	\N	2	\N	\N	\N	pending	2023-04-26 08:52:37	2023-04-26 09:01:00	\N	#TX-000048	no	0
49	Po Box 30499 Jebel Ali Free Zone	P.O. Box: 23318, SHARJAH U A E	15	Allen	allen@email.com	971 8858063	2	truck	2	1	pending	\N	3.2	\N	\N	\N	pending	2023-04-26 09:43:12	2023-04-26 09:43:12	\N	#TX-000049	no	\N
29	Truck Type addres	abc	15	Daniel	daniel@email.com	971 181881818181	2	[]	2	1	approved_by_admin	200	4	\N	Successfully completed the booking	16	delivered	2023-04-24 23:43:51	2023-04-26 10:14:35	\N	#TX-000029	yes	208
53	Po Box 30499 Jebel Ali Free Zone	P.O. Box: 23318, SHARJAH U A E	15	receiver_name	ghaniabro11@gmail.com	receiver_phone	2	truck	2	1	ask_for_qoute	\N	4	\N	\N	\N	pending	2023-04-26 09:47:36	2023-04-26 10:21:18	\N	#TX-000053	yes	\N
46	Po Box 30499 Jebel Ali Free Zone	P.O. Box: 23318, SHARJAH U A E	15	Allen	allen@email.com	971 8858063	2	truck	2	1	approved_by_admin	\N	2.45	\N	\N	\N	qouted	2023-04-25 16:06:04	2023-04-25 16:29:26	\N	#TX-000046	yes	\N
45	Collection Address	Deliver Address	15	Receiver Name	ghaniabro11@gmail.com	1268 03023220821	2	truck	2	1	ask_for_qoute	\N	3	\N	Delivery Note	\N	pending	2023-04-25 16:01:52	2023-04-25 19:50:36	\N	#TX-000045	no	0
47	Truck Type addres	abc	15	Daniel	daniel@email.com	+971 181881818181	3	{"weight":"10","no_of_crts":"2","crt_dimension":"33","no_of_pallets":"2"}	2	1	ask_for_qoute	\N	\N	\N	\N	\N	pending	2023-04-26 08:43:56	2023-04-26 08:53:07	\N	#TX-000047	no	\N
\.


--
-- TOC entry 4467 (class 0 OID 41059)
-- Dependencies: 227
-- Data for Name: categories; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.categories (category_id, lang_code, category_name, unique_category_code, unique_category_text, category_image, category_icon, created_by, parent_category_id, category_status, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- TOC entry 4469 (class 0 OID 41071)
-- Dependencies: 229
-- Data for Name: category_languages; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.category_languages (category_lang_id, category_id_fk, lang_code, category_localized_name, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 4491 (class 0 OID 42220)
-- Dependencies: 256
-- Data for Name: companies; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.companies (id, name, logo, status, created_at, updated_at, company_license) FROM stdin;
1	New Company	public/XpVbpZbXDlglKljK1MWWHHILbHyhm0LrKMQ21Gtw.png	active	2023-04-19 08:31:47	2023-04-19 08:31:47	\N
2	New One Company	6440b17bac063_1681961339.jpg	active	2023-04-20 07:28:59	2023-04-20 07:28:59	6440b17baf008_1681961339.jpg
\.


--
-- TOC entry 4473 (class 0 OID 41087)
-- Dependencies: 233
-- Data for Name: countries; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.countries (country_id, country_name, dial_code, iso_code, lang_code, country_status, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- TOC entry 4475 (class 0 OID 41095)
-- Dependencies: 235
-- Data for Name: country_languages; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.country_languages (country_lang_id, lang_code, country_id_fk, country_localized_name) FROM stdin;
\.


--
-- TOC entry 4489 (class 0 OID 42211)
-- Dependencies: 254
-- Data for Name: deligate_attributes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.deligate_attributes (id, deligate_id, details, created_at, updated_at, name) FROM stdin;
13	1	{"input_type":"text","placeholder":"Weight   kg","label":"Weight   kg","name":"weight","fields":"1"}	2023-04-20 11:39:33	2023-04-20 11:39:33	weight
14	1	[]	2023-04-20 11:39:33	2023-04-20 11:39:33	no_of_crts
30	4	{"input_type":"text","placeholder":"Weight   kg","label":"Weight   kg","name":"weight","fields":"1"}	2023-04-24 20:20:40	2023-04-24 20:20:40	weight
31	4	[]	2023-04-24 20:20:40	2023-04-24 20:20:40	no_of_crts
32	4	{"input_type":"text","placeholder":"Cartn Dimension","label":"Cartn Dimension","name":"crt_dimension","fields":"1"}	2023-04-24 20:20:40	2023-04-24 20:20:40	crt_dimension
33	4	{"input_type":"text","placeholder":"No of Pallets","label":"No of Pallets","name":"no_of_pallets","fields":"1"}	2023-04-24 20:20:40	2023-04-24 20:20:40	no_of_pallets
34	3	{"input_type":"text","placeholder":"Weight   kg","label":"Weight   kg","name":"weight","fields":"1"}	2023-04-24 20:21:19	2023-04-24 20:21:19	weight
35	3	[]	2023-04-24 20:21:19	2023-04-24 20:21:19	no_of_crts
36	3	{"input_type":"text","placeholder":"Cartn Dimension","label":"Cartn Dimension","name":"crt_dimension","fields":"1"}	2023-04-24 20:21:19	2023-04-24 20:21:19	crt_dimension
37	3	{"input_type":"text","placeholder":"No of Pallets","label":"No of Pallets","name":"no_of_pallets","fields":"1"}	2023-04-24 20:21:19	2023-04-24 20:21:19	no_of_pallets
38	2	{"name":"truck","label":"Truck"}	2023-04-24 20:21:38	2023-04-24 20:21:38	truck
43	5	{"input_type":"text","placeholder":"Weight   kg","label":"Weight   kg","name":"weight","fields":"1"}	2023-04-24 20:22:52	2023-04-24 20:22:52	weight
44	5	[]	2023-04-24 20:22:52	2023-04-24 20:22:52	no_of_crts
45	5	{"input_type":"text","placeholder":"Cartn Dimension","label":"Cartn Dimension","name":"crt_dimension","fields":"1"}	2023-04-24 20:22:52	2023-04-24 20:22:52	crt_dimension
46	5	{"input_type":"text","placeholder":"No of Pallets","label":"No of Pallets","name":"no_of_pallets","fields":"1"}	2023-04-24 20:22:52	2023-04-24 20:22:52	no_of_pallets
47	5	[]	2023-04-24 20:22:52	2023-04-24 20:22:52	size[]
\.


--
-- TOC entry 4487 (class 0 OID 42201)
-- Dependencies: 252
-- Data for Name: deligates; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.deligates (id, name, icon, status, created_at, updated_at, slug) FROM stdin;
4	Sea Frieght	6446ac58d0a08_1682353240.png	active	2023-04-24 20:20:40	2023-04-24 20:20:40	sea-frieght
3	Air Freight	6446ac7f4b9d5_1682353279.png	active	2023-04-20 11:46:45	2023-04-24 20:21:19	air-freight
2	Truck	6446ac92282c4_1682353298.png	active	2023-04-20 11:41:51	2023-04-24 20:21:38	truck
5	WareHouse	6446acca7c1e3_1682353354.png	active	2023-04-24 20:22:34	2023-04-24 20:22:34	warehouse
\.


--
-- TOC entry 4483 (class 0 OID 42180)
-- Dependencies: 248
-- Data for Name: driver_details; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.driver_details (id, user_id, driving_license, mulkia, mulkia_number, is_company, company_id, truck_type_id, total_rides, created_at, updated_at, address, latitude, longitude) FROM stdin;
9	11	643d8e3ec56fe_1681755710.png	643d8e3ec9c80_1681755710.png	2828828228	yes	1	2	0	2023-04-17 22:21:50	2023-04-17 22:21:50	\N	\N	\N
11	18	643d8e3ec56fe_1681755710.png	643d8e3ec9c80_1681755710.png	2828828228	yes	1	2	0	2023-04-17 22:21:50	2023-04-17 22:21:50	\N	\N	\N
10	20	643d8e3ec56fe_1681755710.png	643d8e3ec9c80_1681755710.png	2828828228	yes	1	2	0	2023-04-17 22:21:50	2023-04-17 22:21:50	\N	\N	\N
8	16	643d8e3ec56fe_1681755710.png	643d8e3ec9c80_1681755710.png	2828828228	no	0	2	0	2023-04-17 22:21:50	2023-04-17 22:21:50	\N	\N	\N
\.


--
-- TOC entry 4502 (class 0 OID 42282)
-- Dependencies: 267
-- Data for Name: driver_types; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.driver_types (id, type, created_at, updated_at) FROM stdin;
0	Individual	\N	\N
1	Company	\N	\N
\.


--
-- TOC entry 4481 (class 0 OID 41121)
-- Dependencies: 241
-- Data for Name: event_invitations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.event_invitations (id, event_id, name, email, is_allowed_to_invite, show_guest_list, status, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 4479 (class 0 OID 41111)
-- Dependencies: 239
-- Data for Name: events; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.events (id, name, date, start_time, end_time, event_type_id, about, privacy, image, address, latitude, longitude, building, apartment, landmark, active, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 4463 (class 0 OID 41035)
-- Dependencies: 223
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- TOC entry 4477 (class 0 OID 41102)
-- Dependencies: 237
-- Data for Name: languages; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.languages (language_id, language_name, lang_code, language_status, created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- TOC entry 4456 (class 0 OID 40999)
-- Dependencies: 216
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	2014_10_12_000000_create_roles_table	1
2	2014_10_12_100000_create_users_table	1
3	2014_10_12_200000_create_password_resets_table	1
4	2014_10_12_300000_create_failed_jobs_table	1
5	2019_12_14_000001_create_personal_access_tokens_table	1
6	2023_02_19_174049_create_categories_table	1
7	2023_02_23_161940_create_category_languages_table	1
8	2023_03_02_093403_create_role_permissions_table	1
9	2023_03_05_171740_create_table_countries	1
10	2023_03_05_172109_create_table_country_languages	1
11	2023_03_13_065242_create_languages_table	1
12	2023_03_17_101943_create_events_table	1
13	2023_03_17_103944_create_event_invitations_table	1
14	2023_03_28_231534_enable_postgis	1
15	2023_03_29_165153_add_coordinates_to_malls_table	1
16	2023_04_15_112135_add_socail_login_table	1
17	2023_04_15_134435_add_provider_to_users_table	1
18	2023_04_15_134617_add_avator_to_users_table	1
19	2023_04_15_172132_create_driver_details_table	1
20	2023_04_15_172206_create_truck_types_table	1
21	2023_04_15_172234_create_deligates_table	1
22	2023_04_15_172305_create_deligate_attributes_table	1
23	2023_04_15_172329_create_companies_table	1
24	2023_04_15_172402_create_bookings_table	1
25	2023_04_15_172442_create_booking_qoutes_table	1
26	2023_04_15_172522_create_booking_reviews_table	1
27	2023_04_15_172553_create_user_wallets_table	1
28	2023_04_15_172643_create_user_wallet_transactions_table	1
29	2023_04_15_172731_create_notifications_table	1
30	2023_04_15_184036_add_foreign_key_contraint_user_roles	1
31	2023_04_15_184120_add_foreign_key_contraint_driver_details	1
32	2023_04_15_190029_add_foreign_key_contraint_deligate_attributes	1
33	2023_04_15_190126_add_foreign_key_contraint_bookings	1
34	2023_04_15_190145_add_foreign_key_contraint_booking_qoutes	1
35	2023_04_15_190208_add_foreign_key_contraint_booking_reviews	1
36	2023_04_15_190256_add_foreign_key_contraint_user_wallets	1
37	2023_04_17_125531_create_driver_types_table	1
38	2023_04_17_193740_add_column_address_table	1
39	2023_04_18_192604_change_column_data_types	1
40	2023_04_18_193410_change_column_data_booking_qoutes_types	1
49	2023_04_19_090946_modify_driver_id_bookings_nullable	2
50	2023_04_19_165518_add_column_bookings_table	2
51	2023_04_19_165705_add_profile_image_users_table	2
52	2023_04_19_172013_add_commission_column_booking_qoutes	3
53	2023_04_19_140056_create_new_notifications_table	4
54	2023_04_19_184759_add_title_to_new_notificationa_table	4
55	2023_04_20_072743_add_company_license_column	5
56	2023_04_20_110505_add_column_deligate_attriibutes	6
57	2023_04_20_151756_add_column_is_admin_approved_in_booking_qoutes	7
58	2023_04_24_200623_add_column_slug_deligates_table	8
59	2023_04_24_232126_alter_column_bookings_truck_type_id_null	9
60	2023_04_25_193443_add_column_total_amount_bookings	10
61	2023_04_20_154913_add_location_to_driver_details_table	11
62	2023_04_20_155036_add_location_to_driver_details_table	11
63	2023_04_21_140650_add_image_new_notifications	11
\.


--
-- TOC entry 4506 (class 0 OID 44950)
-- Dependencies: 271
-- Data for Name: new_notifications; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.new_notifications (id, user_id, description, generated_by, generated_to, is_read, created_at, updated_at, title, image) FROM stdin;
1	20	New Notifications	\N	\N	\N	2023-04-20 07:45:33	2023-04-20 07:45:33	New Notification	\N
2	16	New Notifications	\N	\N	\N	2023-04-20 07:45:33	2023-04-20 07:45:33	New Notification	\N
3	15	New Notifications	\N	\N	\N	2023-04-20 07:45:33	2023-04-20 07:45:33	New Notification	\N
4	2	My Custom Notification	\N	\N	\N	2023-04-26 09:34:47	2023-04-26 09:34:47	New Notification	6448b7f73bb45_1682487287.png
5	3	My Custom Notification	\N	\N	\N	2023-04-26 09:34:47	2023-04-26 09:34:47	New Notification	6448b7f73ffce_1682487287.png
6	5	My Custom Notification	\N	\N	\N	2023-04-26 09:34:47	2023-04-26 09:34:47	New Notification	6448b7f740bd7_1682487287.png
\.


--
-- TOC entry 4501 (class 0 OID 42273)
-- Dependencies: 266
-- Data for Name: notifications; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.notifications (id, type, content, generated_by, generated_to, is_read, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 4461 (class 0 OID 41028)
-- Dependencies: 221
-- Data for Name: password_resets; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.password_resets (email, token, created_at) FROM stdin;
\.


--
-- TOC entry 4465 (class 0 OID 41047)
-- Dependencies: 225
-- Data for Name: personal_access_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.personal_access_tokens (id, tokenable_type, tokenable_id, name, token, abilities, last_used_at, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 4471 (class 0 OID 41078)
-- Dependencies: 231
-- Data for Name: role_permissions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.role_permissions (permission_id, user_role_id_fk, module_key, permissions, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 4458 (class 0 OID 41006)
-- Dependencies: 218
-- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.roles (id, role, status, created_at, updated_at, deleted_at) FROM stdin;
1	Admin	active	2023-04-19 08:27:21	2023-04-19 08:27:21	\N
2	Truck Driver	active	2023-04-19 08:27:21	2023-04-19 08:27:21	\N
3	Customer	active	2023-04-19 08:27:21	2023-04-26 00:04:26	\N
\.


--
-- TOC entry 4192 (class 0 OID 41448)
-- Dependencies: 243
-- Data for Name: spatial_ref_sys; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.spatial_ref_sys (srid, auth_name, auth_srid, srtext, proj4text) FROM stdin;
\.


--
-- TOC entry 4485 (class 0 OID 42191)
-- Dependencies: 250
-- Data for Name: truck_types; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.truck_types (id, truck_type, dimensions, icon, status, created_at, updated_at) FROM stdin;
2	1 Ton Side Grill	1x2x3	dummy.jpg	active	2023-04-17 19:12:43	2023-04-17 19:12:43
\.


--
-- TOC entry 4499 (class 0 OID 42265)
-- Dependencies: 264
-- Data for Name: user_wallet_transactions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.user_wallet_transactions (id, user_wallet_id, amount, type, created_by, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 4497 (class 0 OID 42258)
-- Dependencies: 262
-- Data for Name: user_wallets; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.user_wallets (id, user_id, amount, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 4460 (class 0 OID 41017)
-- Dependencies: 220
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, name, email, dial_code, phone, phone_verified, password, email_verified_at, role_id, user_phone_otp, user_device_token, user_device_type, user_access_token, firebase_user_key, status, remember_token, created_at, updated_at, deleted_at, provider_id, avatar, address, profile_image) FROM stdin;
1	Admin	admin@admin.com	971	112233445566778899	0	$2y$10$vVRPq9LtGb7Q2gwtDgjCN.pA3A4OUSCKFTkDz9Mm18x5Wvq5TBa3a	\N	1	\N	\N	\N	\N	\N	inactive	\N	2023-04-19 08:27:22	2023-04-19 08:27:22	\N	\N	\N	\N	\N
20	Martin	softcube.web@gmail.com	971	1122333338	1	$2y$10$skQsMuozQI6Yb.gFN15w/uEcuz8/Gd5hb17jOLBlV25uHsX7cxYM2	2023-04-17 22:21:50	2	666					active		2023-04-17 22:21:50	2023-04-17 22:21:50	\N				\N
2	Abdul	abdul@gmail.com	92	29288228	1	$2y$10$Xx/cJke2OC4EJMZOQKcIt.ynONTzgmWJ/g8Kq6bjyK1OvSgcy2/M.	2023-04-20 07:41:47	3	\N	\N	\N	\N	\N	active	\N	\N	\N	\N	\N	\N	\N	\N
3	Ghani	ghani@gmail.com	92	28282828	1	$2y$10$fadPrsY4NV2fcVPulijE9eoSwTJrWZERBuMUhWv3Scmu1knO8hpE.	2023-04-20 07:41:48	3	\N	\N	\N	\N	\N	active	\N	\N	\N	\N	\N	\N	\N	\N
5	Abdul	abdul@gmail.com	92	29288228	1	$2y$10$CzEHhCJG6hIBjUAdmqnIu.MjdZUWjwjw5by.mdgWTB1P5IaHDNAGi	2023-04-20 07:54:20	3	\N	\N	\N	\N	\N	active	\N	\N	\N	\N	\N	\N	\N	\N
6	Ghani	ghani@gmail.com	92	28282828	1	$2y$10$zyR33fr8FGCTNQAy6YWG6ubCShKoDvtNwkxI5C6Ou95Ezv2nEyK8y	2023-04-20 07:54:20	3	\N	\N	\N	\N	\N	active	\N	\N	\N	\N	\N	\N	\N	\N
15	Abdul Ghani	seftware.testing@gmail.com	971	11223382828	1	$2y$10$6hE1X6swdkCpndNu9iDanOKBsqyJFle1RW7RG6m.ew9Cg1R78JbnG	2023-04-17 22:21:50	3	666					active		2023-04-17 22:21:50	2023-04-25 15:58:37	\N				\N
4	Mickey Arthur	ghania11@gmail.com	+971	03023220821	1	$2y$10$xvNqdPnC0tlUsBX1VIJ/Cumg2BjJ5WsLM.NS7iU9T4EW7bdlLR6r.	2023-04-20 07:42:36	3	\N	\N	\N	\N	\N	active	\N	2023-04-20 07:42:36	2023-04-25 16:00:06	\N	\N	\N	\N	\N
16	Micky Arthur	ghaniabro11@gmail.com	971	322082992	1	$2y$10$f2zajjVynCk.0HQJg95l/.Dt0Do4B5fH.3L.O2KybyQ1QAXYPmuE.	2023-04-26 09:59:31	2	666					active		2023-04-17 22:21:50	2023-04-26 09:59:31	\N			\N	\N
\.


--
-- TOC entry 4544 (class 0 OID 0)
-- Dependencies: 257
-- Name: booking_qoutes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.booking_qoutes_id_seq', 106, true);


--
-- TOC entry 4545 (class 0 OID 0)
-- Dependencies: 259
-- Name: booking_reviews_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.booking_reviews_id_seq', 1, false);


--
-- TOC entry 4546 (class 0 OID 0)
-- Dependencies: 269
-- Name: bookings_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.bookings_id_seq', 53, true);


--
-- TOC entry 4547 (class 0 OID 0)
-- Dependencies: 226
-- Name: categories_category_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.categories_category_id_seq', 1, false);


--
-- TOC entry 4548 (class 0 OID 0)
-- Dependencies: 228
-- Name: category_languages_category_lang_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.category_languages_category_lang_id_seq', 1, false);


--
-- TOC entry 4549 (class 0 OID 0)
-- Dependencies: 255
-- Name: companies_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.companies_id_seq', 2, true);


--
-- TOC entry 4550 (class 0 OID 0)
-- Dependencies: 232
-- Name: countries_country_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.countries_country_id_seq', 1, false);


--
-- TOC entry 4551 (class 0 OID 0)
-- Dependencies: 234
-- Name: country_languages_country_lang_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.country_languages_country_lang_id_seq', 1, false);


--
-- TOC entry 4552 (class 0 OID 0)
-- Dependencies: 253
-- Name: deligate_attributes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.deligate_attributes_id_seq', 47, true);


--
-- TOC entry 4553 (class 0 OID 0)
-- Dependencies: 251
-- Name: deligates_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.deligates_id_seq', 5, true);


--
-- TOC entry 4554 (class 0 OID 0)
-- Dependencies: 247
-- Name: driver_details_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.driver_details_id_seq', 1, false);


--
-- TOC entry 4555 (class 0 OID 0)
-- Dependencies: 240
-- Name: event_invitations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.event_invitations_id_seq', 1, false);


--
-- TOC entry 4556 (class 0 OID 0)
-- Dependencies: 238
-- Name: events_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.events_id_seq', 1, false);


--
-- TOC entry 4557 (class 0 OID 0)
-- Dependencies: 222
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- TOC entry 4558 (class 0 OID 0)
-- Dependencies: 236
-- Name: languages_language_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.languages_language_id_seq', 1, false);


--
-- TOC entry 4559 (class 0 OID 0)
-- Dependencies: 215
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 63, true);


--
-- TOC entry 4560 (class 0 OID 0)
-- Dependencies: 270
-- Name: new_notifications_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.new_notifications_id_seq', 6, true);


--
-- TOC entry 4561 (class 0 OID 0)
-- Dependencies: 265
-- Name: notifications_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.notifications_id_seq', 1, false);


--
-- TOC entry 4562 (class 0 OID 0)
-- Dependencies: 224
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.personal_access_tokens_id_seq', 1, false);


--
-- TOC entry 4563 (class 0 OID 0)
-- Dependencies: 230
-- Name: role_permissions_permission_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.role_permissions_permission_id_seq', 1, false);


--
-- TOC entry 4564 (class 0 OID 0)
-- Dependencies: 217
-- Name: roles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.roles_id_seq', 3, true);


--
-- TOC entry 4565 (class 0 OID 0)
-- Dependencies: 249
-- Name: truck_types_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.truck_types_id_seq', 1, false);


--
-- TOC entry 4566 (class 0 OID 0)
-- Dependencies: 263
-- Name: user_wallet_transactions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.user_wallet_transactions_id_seq', 1, false);


--
-- TOC entry 4567 (class 0 OID 0)
-- Dependencies: 261
-- Name: user_wallets_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.user_wallets_id_seq', 1, false);


--
-- TOC entry 4568 (class 0 OID 0)
-- Dependencies: 219
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 6, true);


--
-- TOC entry 4294 (class 2606 OID 42247)
-- Name: booking_qoutes booking_qoutes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_qoutes
    ADD CONSTRAINT booking_qoutes_pkey PRIMARY KEY (id);


--
-- TOC entry 4296 (class 2606 OID 42256)
-- Name: booking_reviews booking_reviews_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.booking_reviews
    ADD CONSTRAINT booking_reviews_pkey PRIMARY KEY (id);


--
-- TOC entry 4304 (class 2606 OID 42331)
-- Name: bookings bookings_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bookings
    ADD CONSTRAINT bookings_pkey PRIMARY KEY (id);


--
-- TOC entry 4266 (class 2606 OID 41069)
-- Name: categories categories_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_pkey PRIMARY KEY (category_id);


--
-- TOC entry 4268 (class 2606 OID 41076)
-- Name: category_languages category_languages_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.category_languages
    ADD CONSTRAINT category_languages_pkey PRIMARY KEY (category_lang_id);


--
-- TOC entry 4292 (class 2606 OID 42228)
-- Name: companies companies_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.companies
    ADD CONSTRAINT companies_pkey PRIMARY KEY (id);


--
-- TOC entry 4272 (class 2606 OID 41093)
-- Name: countries countries_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.countries
    ADD CONSTRAINT countries_pkey PRIMARY KEY (country_id);


--
-- TOC entry 4274 (class 2606 OID 41100)
-- Name: country_languages country_languages_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.country_languages
    ADD CONSTRAINT country_languages_pkey PRIMARY KEY (country_lang_id);


--
-- TOC entry 4290 (class 2606 OID 42218)
-- Name: deligate_attributes deligate_attributes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.deligate_attributes
    ADD CONSTRAINT deligate_attributes_pkey PRIMARY KEY (id);


--
-- TOC entry 4288 (class 2606 OID 42209)
-- Name: deligates deligates_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.deligates
    ADD CONSTRAINT deligates_pkey PRIMARY KEY (id);


--
-- TOC entry 4284 (class 2606 OID 42189)
-- Name: driver_details driver_details_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.driver_details
    ADD CONSTRAINT driver_details_pkey PRIMARY KEY (id);


--
-- TOC entry 4280 (class 2606 OID 41129)
-- Name: event_invitations event_invitations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.event_invitations
    ADD CONSTRAINT event_invitations_pkey PRIMARY KEY (id);


--
-- TOC entry 4278 (class 2606 OID 41119)
-- Name: events events_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.events
    ADD CONSTRAINT events_pkey PRIMARY KEY (id);


--
-- TOC entry 4257 (class 2606 OID 41043)
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- TOC entry 4259 (class 2606 OID 41045)
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- TOC entry 4276 (class 2606 OID 41109)
-- Name: languages languages_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.languages
    ADD CONSTRAINT languages_pkey PRIMARY KEY (language_id);


--
-- TOC entry 4250 (class 2606 OID 41004)
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- TOC entry 4306 (class 2606 OID 44958)
-- Name: new_notifications new_notifications_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.new_notifications
    ADD CONSTRAINT new_notifications_pkey PRIMARY KEY (id);


--
-- TOC entry 4302 (class 2606 OID 42281)
-- Name: notifications notifications_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notifications
    ADD CONSTRAINT notifications_pkey PRIMARY KEY (id);


--
-- TOC entry 4261 (class 2606 OID 41054)
-- Name: personal_access_tokens personal_access_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_pkey PRIMARY KEY (id);


--
-- TOC entry 4263 (class 2606 OID 41057)
-- Name: personal_access_tokens personal_access_tokens_token_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_token_unique UNIQUE (token);


--
-- TOC entry 4270 (class 2606 OID 41085)
-- Name: role_permissions role_permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.role_permissions
    ADD CONSTRAINT role_permissions_pkey PRIMARY KEY (permission_id);


--
-- TOC entry 4252 (class 2606 OID 41015)
-- Name: roles roles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id);


--
-- TOC entry 4286 (class 2606 OID 42199)
-- Name: truck_types truck_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.truck_types
    ADD CONSTRAINT truck_types_pkey PRIMARY KEY (id);


--
-- TOC entry 4300 (class 2606 OID 42271)
-- Name: user_wallet_transactions user_wallet_transactions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_wallet_transactions
    ADD CONSTRAINT user_wallet_transactions_pkey PRIMARY KEY (id);


--
-- TOC entry 4298 (class 2606 OID 42263)
-- Name: user_wallets user_wallets_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_wallets
    ADD CONSTRAINT user_wallets_pkey PRIMARY KEY (id);


--
-- TOC entry 4254 (class 2606 OID 41027)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- TOC entry 4255 (class 1259 OID 41033)
-- Name: password_resets_email_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX password_resets_email_index ON public.password_resets USING btree (email);


--
-- TOC entry 4264 (class 1259 OID 41055)
-- Name: personal_access_tokens_tokenable_type_tokenable_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON public.personal_access_tokens USING btree (tokenable_type, tokenable_id);


--
-- TOC entry 4307 (class 2606 OID 41130)
-- Name: event_invitations event_invitations_event_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.event_invitations
    ADD CONSTRAINT event_invitations_event_id_foreign FOREIGN KEY (event_id) REFERENCES public.events(id);


-- Completed on 2023-04-26 11:26:23

--
-- PostgreSQL database dump complete
--

